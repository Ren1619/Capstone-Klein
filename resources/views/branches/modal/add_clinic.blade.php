<!-- Modal component - works for both add and edit -->
<div id="clinicModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4">
    <!-- Modal Background Overlay -->
    <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 pb-0">
        <h3 class="text-2xl font-bold">
          <span id="modalAction" class="text-[#F91D7C]">Add</span> Branch
        </h3>
        <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      
      <!-- Modal Body -->
      <div class="p-6">
        <form id="clinicForm" method="POST" action="{{ route('branches.store') }}">
          @csrf
          <div id="methodField"></div>
          
          <!-- Hidden field for clinic ID (used when editing) -->
          <input type="hidden" id="clinicId" name="clinic_id" value="">
          
          <div class="mb-4">
            <p class="text-sm mb-2">
              All fields with <span class="text-red-500">*</span> are required.
            </p>
          </div>
          
          <!-- Branch Name Field -->
          <div class="mb-4">
            <input type="text" id="branchName" name="branch_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Branch Name*" required>
          </div>
          
          <!-- Address Field -->
          <div class="mb-4">
            <input type="text" id="address" name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Address*" required>
          </div>
          
          <!-- Contact Number Field -->
          <div class="mb-4">
            <input type="text" id="contactNumber" name="contact_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" placeholder="Contact Number*" required>
          </div>
          
          <!-- Operating Days Fields -->
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <select id="fromDay" name="from_day" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                <option value="" disabled selected>From Day*</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
              </select>
            </div>
            <div>
              <select id="toDay" name="to_day" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" required>
                <option value="" disabled selected>To Day*</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
              </select>
            </div>
          </div>
          
          <!-- Operating Hours Fields -->
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Operating Hours*</label>
            <div class="grid grid-cols-2 gap-4">
              <!-- Start Time -->
              <div class="flex items-center gap-2">
                <div class="flex items-center">
                  <input type="text" id="startHour" name="start_hour" placeholder="00" class="w-9 h-10 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" maxlength="2" required />
                  <div class="flex items-center px-1 font-bold">:</div>
                  <input type="text" id="startMinute" name="start_minute" placeholder="00" class="w-9 h-10 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" maxlength="2" required />
                </div>
                <div class="flex">
                  <button type="button" id="startAM" class="bg-[#F91D7C] text-white h-10 px-2 text-xs font-medium rounded-l-md am-pm-toggle">AM</button>
                  <button type="button" id="startPM" class="bg-gray-200 text-gray-600 h-10 px-2 text-xs font-medium rounded-r-md am-pm-toggle">PM</button>
                  <input type="hidden" name="start_period" id="startPeriod" value="AM">
                </div>
              </div>
              
              <!-- End Time -->
              <div class="flex items-center gap-2">
                <div class="flex items-center">
                  <input type="text" id="endHour" name="end_hour" placeholder="00" class="w-9 h-10 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" maxlength="2" required />
                  <div class="flex items-center px-1 font-bold">:</div>
                  <input type="text" id="endMinute" name="end_minute" placeholder="00" class="w-9 h-10 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" maxlength="2" required />
                </div>
                <div class="flex">
                  <button type="button" id="endAM" class="bg-[#F91D7C] text-white h-10 px-2 text-xs font-medium rounded-l-md am-pm-toggle">AM</button>
                  <button type="button" id="endPM" class="bg-gray-200 text-gray-600 h-10 px-2 text-xs font-medium rounded-r-md am-pm-toggle">PM</button>
                  <input type="hidden" name="end_period" id="endPeriod" value="AM">
                </div>
              </div>
            </div>
          </div>
          
          <!-- Status Field (Only shown when editing) -->
          <div id="statusFieldContainer" class="mb-4 hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <div class="grid grid-cols-2 gap-4">
              <div class="flex items-center">
                <input type="radio" id="activeStatus" name="status" value="active" class="h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]" checked>
                <label for="activeStatus" class="ml-2 text-sm text-gray-700">Active</label>
              </div>
              <div class="flex items-center">
                <input type="radio" id="inactiveStatus" name="status" value="inactive" class="h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                <label for="inactiveStatus" class="ml-2 text-sm text-gray-700">Inactive</label>
              </div>
            </div>
          </div>
          
          <!-- Button Actions -->
          <div class="grid grid-cols-2 gap-4 mt-6">
            <button type="submit" id="submitBtn" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
              Add
            </button>
            <button type="button" id="cancelBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements for better performance
    const modal = document.getElementById('clinicModal');
    const form = document.getElementById('clinicForm');
    const methodField = document.getElementById('methodField');
    const closeButtons = document.querySelectorAll('#closeModalBtn, #cancelBtn, #modalBackdrop');
    
    // Open modal
    function openModal(clinicId = null) {
        resetForm();
        
        if (clinicId) {
            // Edit mode
            document.getElementById('modalAction').textContent = 'Edit';
            document.getElementById('submitBtn').textContent = 'Update';
            document.getElementById('statusFieldContainer').classList.remove('hidden');
            document.getElementById('clinicId').value = clinicId;
            
            // Change form method to PUT for update
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            form.action = `{{ url('clinics') }}/${clinicId}`;
            
            // Fetch branch data via AJAX and populate the form
            fetchBranchData(clinicId);
        } else {
            // Add mode
            document.getElementById('modalAction').textContent = 'Add';
            document.getElementById('submitBtn').textContent = 'Add';
            document.getElementById('statusFieldContainer').classList.add('hidden');
            methodField.innerHTML = '';
            form.action = "{{ route('branches.store') }}";
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    // Function to fetch branch data via AJAX
    function fetchBranchData(clinicId) {
        // Show a loading indicator or disable the form while loading
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Loading...';
        }
        
        // Make the AJAX request to get branch data
        fetch(`/branches/${clinicId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(branch => {
                // Populate form with the returned data
                populateFormWithClinicData(branch);
                
                // Re-enable the submit button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Update';
                }
            })
            .catch(error => {
                console.error('Error fetching branch data:', error);
                alert('Error loading branch data. Please try again.');
                closeModal();
            });
    }
    
    // Function to close modal
    function closeModal() {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }
    
    // Reset form to default state
    function resetForm() {
        if (form) {
            form.reset();
            document.getElementById('clinicId').value = '';
            
            // Reset AM/PM buttons
            resetAmPmButtons('start');
            resetAmPmButtons('end');
        }
    }
    
    // Helper to reset AM/PM button states
    function resetAmPmButtons(prefix) {
        document.getElementById(`${prefix}AM`).classList.add('bg-[#F91D7C]', 'text-white');
        document.getElementById(`${prefix}AM`).classList.remove('bg-gray-200', 'text-gray-600');
        document.getElementById(`${prefix}PM`).classList.add('bg-gray-200', 'text-gray-600');
        document.getElementById(`${prefix}PM`).classList.remove('bg-[#F91D7C]', 'text-white');
        document.getElementById(`${prefix}Period`).value = 'AM';
    }
    
    // Populate form with clinic data for editing
    function populateFormWithClinicData(branch) {
        if (!branch) return;
        
        // Set form fields with branch data
        document.getElementById('branchName').value = branch.name;
        document.getElementById('address').value = branch.address;
        document.getElementById('contactNumber').value = branch.contact;
        document.getElementById('fromDay').value = branch.operating_days_from;
        document.getElementById('toDay').value = branch.operating_days_to;
        
        // Handle operating hours
        if (branch.operating_hours_start) {
            const startParts = branch.operating_hours_start.match(/(\d+):(\d+)\s(AM|PM)/i);
            if (startParts) {
                document.getElementById('startHour').value = startParts[1];
                document.getElementById('startMinute').value = startParts[2];
                setAmPmState('start', startParts[3]);
            }
        }
        
        if (branch.operating_hours_end) {
            const endParts = branch.operating_hours_end.match(/(\d+):(\d+)\s(AM|PM)/i);
            if (endParts) {
                document.getElementById('endHour').value = endParts[1];
                document.getElementById('endMinute').value = endParts[2];
                setAmPmState('end', endParts[3]);
            }
        }
        
        // Set status radio buttons
        if (branch.status) {
            document.getElementById(branch.status === 'active' ? 'activeStatus' : 'inactiveStatus').checked = true;
        }
    }
    
    // Helper to set AM/PM button states
    function setAmPmState(prefix, period) {
        if (period.toUpperCase() === 'PM') {
            document.getElementById(`${prefix}AM`).classList.remove('bg-[#F91D7C]', 'text-white');
            document.getElementById(`${prefix}AM`).classList.add('bg-gray-200', 'text-gray-600');
            document.getElementById(`${prefix}PM`).classList.remove('bg-gray-200', 'text-gray-600');
            document.getElementById(`${prefix}PM`).classList.add('bg-[#F91D7C]', 'text-white');
            document.getElementById(`${prefix}Period`).value = 'PM';
        } else {
            document.getElementById(`${prefix}AM`).classList.add('bg-[#F91D7C]', 'text-white');
            document.getElementById(`${prefix}AM`).classList.remove('bg-gray-200', 'text-gray-600');
            document.getElementById(`${prefix}PM`).classList.add('bg-gray-200', 'text-gray-600');
            document.getElementById(`${prefix}PM`).classList.remove('bg-[#F91D7C]', 'text-white');
            document.getElementById(`${prefix}Period`).value = 'AM';
        }
    }
    
    // Attach close event to all close buttons
    closeButtons.forEach(button => {
        if (button) {
            button.addEventListener('click', closeModal);
        }
    });
    
    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Handle AM/PM toggle buttons
    const amPmButtons = document.querySelectorAll('.am-pm-toggle');
    amPmButtons.forEach(button => {
        button.addEventListener('click', function() {
            const prefix = this.id.includes('start') ? 'start' : 'end';
            const period = this.id.endsWith('AM') ? 'AM' : 'PM';
            setAmPmState(prefix, period);
        });
    });
    
    // Input validation for hours (1-12)
    document.querySelectorAll('[id$="Hour"]').forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value === '0') value = '';
            if (value > 12) value = '12';
            this.value = value;
        });
    });
    
    // Input validation for minutes (0-59)
    document.querySelectorAll('[id$="Minute"]').forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value > 59) value = '59';
            if (value.length === 1) value = '0' + value;
            this.value = value;
        });
    });
    
    // Make functions globally accessible
    window.openClinicModal = function(clinicId) {
        openModal(clinicId);
    };
    
    window.openClinicModalDirect = function() {
        openModal();
    };
    
    window.closeClinicModalDirect = closeModal;
});
</script>