<!-- Product Modal component -->
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen p-4">
    <!-- Modal Background Overlay -->
    <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity modal-backdrop"></div>

    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-xl w-full sm:max-w-3xl mx-auto z-10 transform transition-all">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6">
        <h3 class="text-2xl font-bold">
          <span id="modalAction" class="text-[#F91D7C]">Add</span> Product
        </h3>
        <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn"
          onclick="closeAllModals()">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="px-6 pb-6">
        <form id="productForm" method="POST" action="{{ route('inventory.store') }}" enctype="multipart/form-data">
          @csrf
          <div id="methodField"></div>

          <!-- Hidden field for product ID (used when editing) -->
          <input type="hidden" id="productId" name="product_id" value="">

          <div class="mb-4">
            <p class="text-sm">
              All fields with <span class="text-[#F91D7C]">*</span> are required.
            </p>
          </div>

          <!-- Two-column layout -->
          <div class="flex flex-col md:flex-row md:space-x-6">
            <!-- Left Column - Image Upload Section -->
            <div class="md:w-2/5 mb-6 md:mb-0">
              <div
                class="flex flex-col items-center justify-center border border-gray-300 rounded-lg p-6 h-full hover:border-[#F91D7C] transition-colors">
                <div id="imagePreview" class="mb-4 hidden">
                  <img src="" alt="Product preview" class="max-w-full h-48 object-contain rounded">
                </div>
                <div id="defaultImageIcon" class="mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <label for="productImage"
                  class="cursor-pointer bg-[#F91D7C] bg-opacity-10 text-[#F91D7C] py-2 px-6 rounded-full font-medium text-sm hover:bg-opacity-20 transition-colors">
                  Browse File
                </label>
                <input type="file" id="productImage" name="product_image" class="hidden" accept="image/*">
              </div>
            </div>

            <!-- Right Column - Form Fields Section -->
            <div class="md:w-3/5 space-y-6">
              <!-- Product Name Field -->
              <div>
                <input type="text" id="productName" name="product_name"
                  class="w-full px-0 py-2 border-0 border-b border-gray-300 focus:border-[#F91D7C] focus:ring-0 focus:outline-none text-gray-900"
                  placeholder="Product Name*" required>
              </div>

              <!-- Measurement Unit Field -->
              <div>
                <input type="text" id="measurementUnit" name="measurement_unit"
                  class="w-full px-0 py-2 border-0 border-b border-gray-300 focus:border-[#F91D7C] focus:ring-0 focus:outline-none text-gray-900"
                  placeholder="Measurement Unit*" required>
              </div>

              <!-- Price Field -->
              <div>
                <input type="text" id="price" name="price"
                  class="w-full px-0 py-2 border-0 border-b border-gray-300 focus:border-[#F91D7C] focus:ring-0 focus:outline-none text-gray-900"
                  placeholder="Price*" required>
              </div>

              <!-- Quantity Field -->
              <div>
                <input type="number" id="quantity" name="quantity" min="0"
                  class="w-full px-0 py-2 border-0 border-b border-gray-300 focus:border-[#F91D7C] focus:ring-0 focus:outline-none text-gray-900"
                  placeholder="Quantity*" required>
              </div>

              <!-- Category Field -->
              <div>
                <select id="category" name="category_id"
                  class="w-full px-0 py-2 border-0 border-b border-gray-300 focus:border-[#F91D7C] focus:ring-0 focus:outline-none text-gray-900 bg-transparent appearance-none"
                  required>
                  <option value="" disabled selected>Select Category*</option>
                  @foreach($categories as $category)
            <option value="{{ $category->category_ID }}">{{ $category->name }}</option>
          @endforeach
                </select>
                <div class="relative float-right -mt-8 mr-2 pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
              </div>

              <!-- Branch Field -->
              <div>
                <select id="branch" name="branch_id"
                  class="w-full px-0 py-2 border-0 border-b border-gray-300 focus:border-[#F91D7C] focus:ring-0 focus:outline-none text-gray-900 bg-transparent appearance-none"
                  required>
                  <option value="" disabled selected>Select Branch*</option>
                  @foreach($branches as $branch)
            <option value="{{ $branch->branch_ID }}">{{ $branch->name }}</option>
          @endforeach
                </select>
                <div class="relative float-right -mt-8 mr-2 pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Dotted Border Line -->
          <div class="my-6 border-t border-dashed border-gray-300"></div>

          <!-- Button Actions -->
          <div class="flex justify-end space-x-4">
            <button type="submit" id="submitBtn"
              class="w-36 h-10 flex items-center justify-center bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
              Add
            </button>
            <button type="button" id="cancelBtn" onclick="closeAllModals()"
              class="w-36 h-10 flex items-center justify-center bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
    console.log('Initializing product modal');

    // DOM Elements
    const modal = document.getElementById('productModal');
    const modalBackdrop = document.querySelector('#productModal .modal-backdrop');
    const form = document.getElementById('productForm');
    const methodField = document.getElementById('methodField');
    const productImageInput = document.getElementById('productImage');
    const priceInput = document.getElementById('price');

    // Core modal functions
    function openModal(mode = 'add', productId = null) {
      console.log('Opening product modal in ' + mode + ' mode');

      resetForm();
      setModalMode(mode);

      // Change this line in the openModal function
      if (mode === 'edit' && productId) {
        // Change form method to PUT for update
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        // CHANGE THIS LINE:
        form.action = "{{ route('inventory.store') }}".replace('store', productId);

        // TO THIS:
        form.action = "{{ url('inventory') }}/" + productId;

        // Fetch product data via AJAX and populate the form
        fetchProductData(productId);
      } else {
        // Add mode
        methodField.innerHTML = '';
        form.action = "{{ route('inventory.store') }}";
      }

      if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }
    }

    function closeModal() {
      console.log('Closing product modal');
      if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        resetForm();
      }
    }

    // Helper functions
    function resetForm() {
      if (form) {
        form.reset();
        document.getElementById('productId').value = '';

        // Reset image preview
        const imagePreview = document.getElementById('imagePreview');
        const defaultImageIcon = document.getElementById('defaultImageIcon');
        if (imagePreview && defaultImageIcon) {
          imagePreview.classList.add('hidden');
          defaultImageIcon.classList.remove('hidden');
        }
      }
    }

    function setModalMode(mode) {
      // Update modal title and button text
      const modalAction = document.getElementById('modalAction');
      const submitBtn = document.getElementById('submitBtn');

      if (mode === 'add') {
        modalAction.textContent = 'Add';
        submitBtn.textContent = 'Add';
      } else {
        modalAction.textContent = 'Edit';
        submitBtn.textContent = 'Update';
      }
    }

    // Function to fetch product data via AJAX
    function fetchProductData(productId) {
      // Show a loading indicator or disable the form while loading
      const submitBtn = document.getElementById('submitBtn');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Loading...';
      }

      // Make the AJAX request to get product data
      fetch(`/inventory/${productId}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(product => {
          // Populate form with the returned data
          populateFormWithProductData(product);

          // Re-enable the submit button
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update';
          }
        })
        .catch(error => {
          console.error('Error fetching product data:', error);
          alert('Error loading product data. Please try again.');
          closeModal();
        });
    }

    function populateFormWithProductData(product) {
      if (!product) return;

      // Set hidden product ID field
      document.getElementById('productId').value = product.product_ID;

      // Set basic fields
      document.getElementById('productName').value = product.name;
      document.getElementById('measurementUnit').value = product.measurement_unit;
      document.getElementById('price').value = product.price;
      document.getElementById('quantity').value = product.quantity;
      document.getElementById('category').value = product.category_ID;
      document.getElementById('branch').value = product.branch_ID;

      // Set image preview if exists (this would be implemented in a real application)
      // For now, we'll just leave the default icon visible
    }

    // Event handlers
    // Handle image upload preview
    if (productImageInput) {
      productImageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            const imagePreview = document.getElementById('imagePreview');
            const defaultImageIcon = document.getElementById('defaultImageIcon');
            if (imagePreview && defaultImageIcon) {
              const img = imagePreview.querySelector('img');
              img.src = e.target.result;
              imagePreview.classList.remove('hidden');
              defaultImageIcon.classList.add('hidden');
            }
          };
          reader.readAsDataURL(file);
        }
      });
    }

    // Format price input
    if (priceInput) {
      priceInput.addEventListener('blur', function () {
        if (this.value) {
          this.value = parseFloat(this.value).toFixed(2);
        }
      });
    }

    // Make functions globally accessible
    window.openProductModalDirect = function () {
      openModal('add');
    };

    window.openEditProductModalDirect = function (productId) {
      openModal('edit', productId);
    };

    window.closeProductModalDirect = function () {
      closeModal();
    };

    // Close modal when backdrop is clicked
    if (modalBackdrop) {
      modalBackdrop.addEventListener('click', closeModal);
    }

    // Close modal on escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
        closeModal();
      }
    });
  });
</script>