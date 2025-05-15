<?php

namespace App\Http\Controllers;

use App\Models\AccountRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountRoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = AccountRole::withCount('accounts')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $roles,
        ]);
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:255|unique:accounts_role,role_name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $role = AccountRole::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Role created successfully',
            'data' => $role,
        ], 201);
    }

    /**
     * Display the specified role.
     */
    public function show($id)
    {
        $role = AccountRole::withCount('accounts')->find($id);

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $role,
        ]);
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, $id)
    {
        $role = AccountRole::find($id);

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'role_name' => 'sometimes|string|max:255|unique:accounts_role,role_name,' . $id . ',role_ID',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $role->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Role updated successfully',
            'data' => $role,
        ]);
    }

    /**
     * Remove the specified role.
     */
    public function destroy($id)
    {
        $role = AccountRole::find($id);

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found',
            ], 404);
        }

        // Check if role is being used by any accounts
        if ($role->accounts()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete role. It is currently assigned to one or more accounts.',
            ], 409);
        }

        $role->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully',
        ]);
    }

    /**
     * Get accounts for a specific role.
     */
    public function getAccounts($id)
    {
        $role = AccountRole::with('accounts.branch')->find($id);

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'role' => $role,
                'accounts' => $role->accounts,
            ],
        ]);
    }
}