// public/js/product-modal.js
document.addEventListener('DOMContentLoaded', function () {
    // Get references to elements
    const addProductButton = document.querySelector('button.bg-pink-600'); // The pink "Add Product" button
    const modal = document.getElementById('productModal');
    
    // Only proceed if we found both elements
    if (!addProductButton || !modal) {
        console.error('Could not find button or modal elements');
        return;
    }
    
    const closeModal = document.getElementById('closeModal');
    const cancelButton = document.getElementById('cancelButton');
    const fileInput = document.getElementById('productImage');
    
    if (!closeModal || !cancelButton || !fileInput) {
        console.error('Could not find modal control elements');
        return;
    }
    
    const dropZone = fileInput.parentElement;

    // Show modal when Add Product button is clicked
    addProductButton.addEventListener('click', function () {
        modal.classList.remove('hidden');
    });

    // Hide modal when Close button is clicked
    closeModal.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    // Hide modal when Cancel button is clicked
    cancelButton.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    // Hide modal when clicking outside of it
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Trigger file input when clicking on drop zone
    dropZone.addEventListener('click', function () {
        fileInput.click();
    });

    // Handle file selection
    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                // Create and display preview image
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-contain';

                // Clear drop zone and append image
                while (dropZone.firstChild) {
                    dropZone.removeChild(dropZone.firstChild);
                }

                dropZone.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
    
    console.log('Product modal initialized');
});