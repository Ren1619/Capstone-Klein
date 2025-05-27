<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a list of accounts.
     */
    public function index(Request $request)
    {
        try {
            $query = Account::query();

            // Always load relationships
            $query->with(['role', 'branch']);

            // Filter by role if provided
            if ($request->has('role')) {
                if ($request->role === 'staff') {
                    // Get IDs of staff roles (any role with 'staff' in the name)
                    $staffRoleIds = \App\Models\AccountRole::where('role_name', 'LIKE', '%staff%')
                        ->pluck('role_ID');

                    // Filter accounts by these role IDs
                    if ($staffRoleIds->count() > 0) {
                        $query->whereIn('role_ID', $staffRoleIds);
                    }
                }
            }

            // Add pagination
            $accounts = $query->paginate(10);

            return response()->json([
                'status' => 'success',
                'data' => $accounts,
            ]);
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Account index error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve accounts: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created account.
     */
    public function store(Request $request)
    {
        dd(auth()->check(), auth()->user(), session()->all());
        $validator = Validator::make($request->all(), [
            'role_ID' => 'required|exists:accounts_role,role_ID',
            'branch_ID' => 'required|exists:branches,branch_ID',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:accounts',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $account = Account::create([
            'role_ID' => $request->role_ID,
            'branch_ID' => $request->branch_ID,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (auth()->check()) {
            \App\Models\Log::create([
                'account_ID' => auth()->user()->account_ID,
                'actions' => 'Account Creation',
                'descriptions' => 'Created new account for: ' . $request->first_name . ' ' . $request->last_name . ' (' . $request->email . ')',
                'timestamp' => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Account created successfully',
            'data' => $account->load(['role', 'branch']),
        ], 201);
    }


    /**
     * Display the specified account.
     */
    public function show($id)
    {
        $account = Account::with(['role', 'branch'])->find($id);

        if (!$account) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $account,
        ]);
    }

    /**
     * Update the specified account.
     */
    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'role_ID' => 'sometimes|exists:accounts_role,role_ID',
            'branch_ID' => 'sometimes|exists:branches,branch_ID',
            'last_name' => 'sometimes|string|max:255',
            'first_name' => 'sometimes|string|max:255',
            'contact_number' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:accounts,email,' . $id . ',account_ID',
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $updateData = $request->all();

        if (isset($updateData['password'])) {
            $updateData['password'] = Hash::make($updateData['password']);
        }

        // Store old values for logging
        $changes = [];
        foreach ($updateData as $field => $newValue) {
            if ($field !== 'password' && $account->{$field} != $newValue) {
                $changes[] = $field . ': ' . $account->{$field} . ' → ' . $newValue;
            } elseif ($field === 'password') {
                $changes[] = 'password updated';
            }
        }

        $account->update($updateData);

        // Log account update
        if (!empty($changes)) {
            \App\Models\Log::create([
                'account_ID' => auth()->user()->account_ID,
                'actions' => 'Account Update',
                'descriptions' => 'Updated account ' . $account->first_name . ' ' . $account->last_name . ': ' . implode(', ', $changes),
                'timestamp' => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Account updated successfully',
            'data' => $account->load(['role', 'branch']),
        ]);
    }

    /**
     * Remove the specified account.
     */
    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account not found',
            ], 404);
        }

        // Store account details before deletion
        $accountInfo = $account->first_name . ' ' . $account->last_name . ' (' . $account->email . ')';

        $account->delete();

        $user = auth()->user();
        \App\Models\Log::create([
            'account_ID' => $user ? $user->account_ID : null,
            'actions' => 'Account Deletion',
            'descriptions' => 'Deleted account: ' . $accountInfo,
            'timestamp' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Account deleted successfully',
        ]);
    }

    /**
     * Get accounts by role.
     */
    public function getByRole($roleId)
    {
        $accounts = Account::where('role_ID', $roleId)
            ->with(['role', 'branch'])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $accounts,
        ]);
    }

    /**
     * Get accounts by branch.
     */
    public function getByBranch($branchId)
    {
        $accounts = Account::where('branch_ID', $branchId)
            ->with(['role', 'branch'])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $accounts,
        ]);
    }
}