<!-- Service Category Modal -->
<div id="serviceCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen p-4">
    <!-- Modal Background Overlay -->
    <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity modal-backdrop"></div>

    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-xl w-full sm:max-w-md mx-auto z-10 transform transition-all">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200">
        <h3 class="text-xl font-bold">
          <span class="modal-action text-[#F91D7C]">Add</span> Service Category
        </h3>
        <button type="button" class="text-gray-400 hover:text-gray-500 close-modal">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-4 sm:p-6">
        <form id="addCategoryForm" method="POST" action="{{ route('categories.store') }}">
          @csrf
          <!-- Hidden field for category type -->
          <input type="hidden" name="category_type" value="service">

          <!-- Required fields note -->
          <div class="mb-4">
            <p class="text-sm text-gray-600">
              All fields with <span class="text-[#F91D7C]">*</span> are required.
            </p>
          </div>

          <!-- Category Name Field -->
          <div class="mb-4">
            <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">
              Category Name <span class="text-[#F91D7C]">*</span>
            </label>
            <input type="text" name="category_name" id="categoryName"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
              placeholder="Category Name" required>
          </div>

          <!-- Description Field -->
          <div class="mb-6">
            <label for="categoryDescription" class="block text-sm font-medium text-gray-700 mb-1">
              Description
            </label>
            <textarea id="categoryDescription" name="description" rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
              placeholder="Briefly describe this category"></textarea>
          </div>

          <!-- Button Actions -->
          <div class="flex justify-end space-x-4">
            <button type="submit"
              class="px-4 py-2 bg-[#F91D7C] hover:bg-[#F91D7C]/90 text-white font-medium rounded-md transition-colors">
              Save Category
            </button>
            <button type="button"
              class="px-4 py-2 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors close-modal">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Modal elements
    const modal = document.getElementById('serviceCategoryModal');
    const closeButtons = document.querySelectorAll('.close-modal');
    const modalBackdrop = document.querySelector('.modal-backdrop');

    // Global function to open the modal
    window.openCategoryModal = function () {
      if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }
    };

    // Function to close the modal
    function closeModal() {
      if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('addCategoryForm').reset();
      }
    }

    // Close modal when clicking close buttons
    closeButtons.forEach(button => {
      button.addEventListener('click', closeModal);
    });

    // Close modal when clicking on backdrop
    if (modalBackdrop) {
      modalBackdrop.addEventListener('click', closeModal);
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
        closeModal();
      }
    });
  });
</script>