// SweetAlert Utility Functions

/**
 * Shows a success message using SweetAlert
 * @param {string} message - The success message to display
 * @param {string} title - Optional title (defaults to 'Success!')
 * @param {function} callback - Optional callback function to execute after closing
 */
function showSuccess(message, title = 'Success!', callback = null) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        confirmButtonColor: '#F91D7C',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

/**
 * Shows an error message using SweetAlert
 * @param {string} message - The error message to display
 * @param {string} title - Optional title (defaults to 'Error!')
 */
function showError(message, title = 'Error!') {
    Swal.fire({
        title: title,
        text: message,
        icon: 'error',
        confirmButtonColor: '#F91D7C',
        confirmButtonText: 'OK'
    });
}

/**
 * Shows a warning message using SweetAlert
 * @param {string} message - The warning message to display
 * @param {string} title - Optional title (defaults to 'Warning!')
 */
function showWarning(message, title = 'Warning!') {
    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        confirmButtonColor: '#F91D7C',
        confirmButtonText: 'OK'
    });
}

/**
 * Shows a confirmation dialog using SweetAlert
 * @param {string} message - The confirmation message
 * @param {string} title - Optional title (defaults to 'Are you sure?')
 * @param {string} confirmText - Optional text for confirm button (defaults to 'Yes, proceed!')
 * @param {string} cancelText - Optional text for cancel button (defaults to 'Cancel')
 * @param {function} confirmCallback - Function to call if confirmed
 * @param {function} cancelCallback - Optional function to call if cancelled
 */
function confirmAction(message, title = 'Are you sure?', confirmText = 'Yes, proceed!', cancelText = 'Cancel', confirmCallback, cancelCallback = null) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#F91D7C',
        cancelButtonColor: '#6B7280',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText
    }).then((result) => {
        if (result.isConfirmed && typeof confirmCallback === 'function') {
            confirmCallback();
        } else if (result.dismiss === Swal.DismissReason.cancel && typeof cancelCallback === 'function') {
            cancelCallback();
        }
    });
}

/**
 * Shows a delete confirmation dialog using SweetAlert
 * @param {string} itemName - Name of the item to delete
 * @param {function} deleteCallback - Function to call if delete is confirmed
 * @param {string} message - Optional custom message (defaults to a standard delete message)
 */
function confirmDelete(itemName, deleteCallback, message = null) {
    const deleteMessage = message || `You are about to delete "${itemName}". This action cannot be undone!`;
    
    Swal.fire({
        title: 'Delete Confirmation',
        text: deleteMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed && typeof deleteCallback === 'function') {
            deleteCallback();
        }
    });
}

/**
 * Shows a toast notification using SweetAlert
 * @param {string} message - The message to display
 * @param {string} icon - The icon to use (success, error, warning, info, question)
 * @param {number} timer - Optional duration in milliseconds (defaults to 3000)
 */
function showToast(message, icon = 'success', timer = 3000) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({
        icon: icon,
        title: message
    });
}

/**
 * Shows a loading indicator
 * @param {string} message - Optional message to display (defaults to 'Please wait...')
 * @returns {function} - Function to close the loading indicator
 */
function showLoading(message = 'Please wait...') {
    Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    return () => {
        Swal.close();
    };
}

// For form handling with AJAX
function setupFormWithSweetAlert(formSelector, options = {}) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    const {
        successMessage = 'Operation completed successfully!',
        errorMessage = 'Something went wrong. Please try again.',
        redirectUrl = null,
        resetForm = true,
        successCallback = null,
        beforeSubmit = null,
        method = null, // 'POST', 'PUT', etc.
        customFormData = null // Function to return custom form data
    } = options;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Run before submit callback if provided
        if (typeof beforeSubmit === 'function') {
            const shouldContinue = beforeSubmit();
            if (shouldContinue === false) return;
        }
        
        const closeLoading = showLoading('Processing...');
        
        // Determine which method to use
        const httpMethod = method || form.getAttribute('method') || 'POST';
        
        // Get form data
        let formData;
        if (typeof customFormData === 'function') {
            formData = customFormData();
        } else {
            formData = new FormData(form);
        }
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Build fetch options
        const fetchOptions = {
            method: httpMethod,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        };
        
        // For JSON data
        if (formData instanceof Object && !(formData instanceof FormData)) {
            fetchOptions.headers['Content-Type'] = 'application/json';
            fetchOptions.body = JSON.stringify(formData);
        }
        
        // Submit the form
        fetch(form.action, fetchOptions)
            .then(response => {
                closeLoading();
                
                if (response.redirected) {
                    window.location.href = response.url;
                    return { success: true };
                }
                
                return response.json().catch(() => {
                    return { success: response.ok };
                });
            })
            .then(data => {
                if (data.success || (data.status && data.status === 'success')) {
                    showSuccess(data.message || successMessage, 'Success!', () => {
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else if (typeof successCallback === 'function') {
                            successCallback(data);
                        }
                    });
                    
                    if (resetForm) {
                        form.reset();
                    }
                } else {
                    let errorText = errorMessage;
                    
                    if (data.message) {
                        errorText = data.message;
                    } else if (data.errors) {
                        const errors = Object.values(data.errors).flat();
                        errorText = errors.join(', ');
                    }
                    
                    showError(errorText);
                }
            })
            .catch(error => {
                closeLoading();
                console.error('Error:', error);
                showError(errorMessage);
            });
    });
}

// Apply delete confirmation to all delete buttons/forms with the data-confirm-delete attribute
function setupDeleteConfirmations() {
    // For forms
    document.querySelectorAll('form[data-confirm-delete]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const itemName = this.getAttribute('data-confirm-delete') || 'this item';
            
            confirmDelete(itemName, () => {
                this.submit();
            });
        });
    });
    
    // For links/buttons
    document.querySelectorAll('[data-confirm-delete]:not(form)').forEach(element => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            
            const itemName = this.getAttribute('data-confirm-delete') || 'this item';
            const url = this.getAttribute('href') || this.getAttribute('data-url');
            const method = this.getAttribute('data-method') || 'POST';
            
            if (!url) {
                console.error('No URL provided for delete action');
                return;
            }
            
            confirmDelete(itemName, () => {
                // Create and submit a form for this delete action
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = method;
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
}

// Initialize SweetAlert functionality
document.addEventListener('DOMContentLoaded', function() {
    setupDeleteConfirmations();
    
    // Check for flash messages from session and display them
    if (typeof flashMessages !== 'undefined') {
        if (flashMessages.success) {
            showSuccess(flashMessages.success);
        }
        if (flashMessages.error) {
            showError(flashMessages.error);
        }
        if (flashMessages.warning) {
            showWarning(flashMessages.warning);
        }
        if (flashMessages.info) {
            showToast(flashMessages.info, 'info');
        }
    }
});