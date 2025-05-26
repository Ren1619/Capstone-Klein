<!-- Branch Modal -->
<div id="branchModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4">
    <!-- Modal Background Overlay -->
    <div class="fixed inset-0 bg-black/70 transition-opacity" id="modalOverlay"></div>    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 pb-4">
        <h3 class="text-2xl font-bold">
          <span id="modalAction" class="text-[#F91D7C]">Add</span> Branch
        </h3>
        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeBranchModal()">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6 pt-2">
        <form id="branchForm" method="POST" action="{{ route('branches.store') }}">
          @csrf
          <input type="hidden" name="_method" id="formMethod" value="POST">
          <input type="hidden" id="branch_id" name="branch_id" value="">

          <div class="mb-4">
            <p class="text-sm mb-2">
              All fields with <span class="text-red-500">*</span> are required.
            </p>
          </div>

          <!-- Branch Name -->
          <div class="mb-4">
            <input type="text" id="branch_name" name="branch_name"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
              placeholder="Branch Name*" required>
          </div>

          <!-- Address -->
          <div class="mb-4">
            <input type="text" id="address" name="address"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
              placeholder="Address*" required>
          </div>

          <!-- Contact Number -->
          <div class="mb-4">
            <input type="text" id="contact_number" name="contact_number"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
              placeholder="Contact Number*" required>
          </div>

          <!-- Operating Days -->
          <div class="grid grid-cols-2 gap-4 mb-4">
            <select id="from_day" name="from_day"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
              required>
              <option value="" disabled selected>From Day*</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
            </select>

            <select id="to_day" name="to_day"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C]"
              required>
              <option value="" disabled selected>To Day*</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
            </select>
          </div>

          <!-- Operating Hours -->
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Operating Hours*</label>
            <div class="grid grid-cols-2 gap-4">
              <!-- Start Time -->
              <div class="flex items-center gap-2">                <input type="number" id="start_hour" name="start_hour"
                  class="w-16 h-12 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] text-lg"
                  min="1" max="12" required>
                <span class="font-bold text-xl">:</span>
                <input type="number" id="start_minute" name="start_minute"
                  class="w-16 h-12 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] text-lg"
                  min="0" max="59" value="00" required>
                <select id="start_period" name="start_period"
                  class="h-12 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] text-lg">
                  <option value="AM">AM</option>
                  <option value="PM">PM</option>
                </select>
              </div>

              <!-- End Time -->
              <div class="flex items-center gap-2">                <input type="number" id="end_hour" name="end_hour"
                  class="w-16 h-12 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] text-lg"
                  min="1" max="12" required>
                <span class="font-bold text-xl">:</span>
                <input type="number" id="end_minute" name="end_minute"
                  class="w-16 h-12 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-[#F91D7C] text-lg"
                  min="0" max="59" value="00" required>
                <select id="end_period" name="end_period"
                  class="h-12 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] text-lg">
                  <option value="AM">AM</option>
                  <option value="PM">PM</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Status (Only for Edit mode) -->
          <div id="statusFieldContainer" class="mb-4 hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <div class="grid grid-cols-2 gap-4">
              <label class="flex items-center">
                <input type="radio" name="status" value="active" checked
                  class="h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                <span class="ml-2 text-sm text-gray-700">Active</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="status" value="inactive" class="h-4 w-4 text-[#F91D7C] focus:ring-[#F91D7C]">
                <span class="ml-2 text-sm text-gray-700">Inactive</span>
              </label>
            </div>
          </div>

          <!-- Buttons -->
          <div class="grid grid-cols-2 gap-4 mt-6">
            <button type="submit" id="submitBtn"
              class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
              Add
            </button>
            <button type="button" onclick="closeBranchModal()"
              class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
            form.action = `{{ url('branches') }}/${clinicId}`;
            
            // Fetch branch data via AJAX and populate the form
            fetchBranchData(clinicId);
  // Branch Modal Functions
  let currentBranchId = null;

  // Open modal for creating new branch
  function openBranchModalDirect() {
    resetBranchForm();

    // Set to create mode
    document.getElementById('modalAction').textContent = 'Add';
    document.getElementById('submitBtn').textContent = 'Add';
    document.getElementById('statusFieldContainer').classList.add('hidden');
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('branchForm').action = "{{ route('branches.store') }}";

    // Show modal
    document.getElementById('branchModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  // Open modal for editing existing branch
  function openBranchModal(branchId) {
    currentBranchId = branchId;
    resetBranchForm();

    // Set to edit mode
    document.getElementById('modalAction').textContent = 'Edit';
    document.getElementById('submitBtn').textContent = 'Update';
    document.getElementById('statusFieldContainer').classList.remove('hidden');
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('branchForm').action = `/branches/${branchId}`;

    // Show modal
    document.getElementById('branchModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Fetch and populate branch data
    fetchBranchData(branchId);
  }

  // Fetch branch data for editing
  function fetchBranchData(branchId) {
    fetch(`/branches/${branchId}`)
      .then(response => response.json())
      .then(result => {
        if (result.success && result.data) {
          populateBranchForm(result.data);
        } else {
          alert('Error loading branch data');
          closeBranchModal();
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error loading branch data');
        closeBranchModal();
      });
  }

  // Populate form with branch data
  function populateBranchForm(branch) {
    document.getElementById('branch_name').value = branch.name || '';
    document.getElementById('address').value = branch.address || '';
    document.getElementById('contact_number').value = branch.contact || '';
    document.getElementById('from_day').value = branch.operating_days_from || '';
    document.getElementById('to_day').value = branch.operating_days_to || '';

    // Parse operating hours
    if (branch.operating_hours_start) {
      const startMatch = branch.operating_hours_start.match(/(\d+):(\d+)\s*(AM|PM)/i);
      if (startMatch) {
        document.getElementById('start_hour').value = parseInt(startMatch[1]);
        document.getElementById('start_minute').value = parseInt(startMatch[2]);
        document.getElementById('start_period').value = startMatch[3].toUpperCase();
      }
    }

    if (branch.operating_hours_end) {
      const endMatch = branch.operating_hours_end.match(/(\d+):(\d+)\s*(AM|PM)/i);
      if (endMatch) {
        document.getElementById('end_hour').value = parseInt(endMatch[1]);
        document.getElementById('end_minute').value = parseInt(endMatch[2]);
        document.getElementById('end_period').value = endMatch[3].toUpperCase();
      }
    }

    // Set status
    if (branch.status) {
      document.querySelector(`input[name="status"][value="${branch.status}"]`).checked = true;
    }
  }

  // Reset form
  function resetBranchForm() {
    document.getElementById('branchForm').reset();
    document.getElementById('branch_id').value = '';
    document.getElementById('start_minute').value = '00';
    document.getElementById('end_minute').value = '00';
    currentBranchId = null;
  }

  // Close modal
  function closeBranchModal() {
    document.getElementById('branchModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    resetBranchForm();
  }

  // Confirmation for delete
  function confirmDelete(branchName) {
    return confirm(`Are you sure you want to delete the branch "${branchName}"?\n\nThis action cannot be undone.`);
  }

  // Initialize on page load
  document.addEventListener('DOMContentLoaded', function () {
    // Close modal on overlay click
    document.getElementById('modalOverlay').addEventListener('click', closeBranchModal);

    // Close modal on escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !document.getElementById('branchModal').classList.contains('hidden')) {
        closeBranchModal();
      }
    });

    // Format minute inputs
    ['start_minute', 'end_minute'].forEach(id => {
      document.getElementById(id).addEventListener('blur', function () {
        if (this.value.length === 1) {
          this.value = '0' + this.value;
        }
      });
    });

    // Handle real-time search
    const searchInput = document.getElementById('branchSearchInput');
    if (searchInput) {
      let searchTimeout;
      searchInput.addEventListener('input', function (e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          this.form.submit();
        }, 500);
      });
    }
  });

  // Make functions globally accessible
  window.openBranchModal = openBranchModal;
  window.openBranchModalDirect = openBranchModalDirect;
  window.closeBranchModal = closeBranchModal;
  window.confirmDelete = confirmDelete;
  window.resetBranchForm = resetBranchForm;
  window.populateBranchForm = populateBranchForm;
  window.showBranchModal = function () {
    document.getElementById('branchModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  };
</script>