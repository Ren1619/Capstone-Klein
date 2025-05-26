<!-- Button to open modal -->
<!-- <button class="visitFeedbackBtn bg-[#F91D7C] text-white px-6 py-2 rounded hover:bg-[#F91D7C]/90">
  Visit Feedback
</button> -->

{{-- Visit Feedback Modal --}}
<div id="visitFeedbackModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity" id="modalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Visit</span> Feedback
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="visitFeedbackForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="mb-4">
                        <p class="text-sm mb-2">
                            All fields with <span class="text-[#F91D7C]">*</span> are required.
                        </p>
                    </div>

                    <!-- Appointment Code Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Appointment code
                        </label>
                        <input type="text" id="appointmentCode" name="appointmentCode"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent">
                    </div>

                    <!-- Rating Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            How was your appointment?
                        </label>
                        <div class="flex space-x-3">
                            <button type="button" class="rating-star" data-rating="1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </button>
                            <button type="button" class="rating-star" data-rating="2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </button>
                            <button type="button" class="rating-star" data-rating="3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </button>
                            <button type="button" class="rating-star" data-rating="4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </button>
                            <button type="button" class="rating-star" data-rating="5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </button>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="">
                    </div>

                    <!-- Feedback Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Feedback<span class="text-[#F91D7C]">*</span>
                        </label>
                        <textarea id="feedback" name="feedback" rows="6"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent"
                            required></textarea>
                    </div>

                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Submit
                        </button>
                        <button type="button" id="cancelBtn"
                            class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal JavaScript - Directly embedded within the component --}}
<script>
    // Create a global object to store feedback functions
    window.visitFeedbackFunctions = {};

    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const visitFeedbackModal = document.getElementById('visitFeedbackModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const visitFeedbackForm = document.getElementById('visitFeedbackForm');
        const visitFeedbackBtns = document.querySelectorAll('.visitFeedbackBtn');
        const ratingStars = document.querySelectorAll('.rating-star');

        console.log('Visit Feedback Modal initialized');
        console.log('Found feedback buttons:', visitFeedbackBtns.length);

        // Open Modal Function
        function openModal() {
            console.log('Opening feedback modal');
            if (visitFeedbackModal) {
                visitFeedbackModal.classList.remove('hidden');
                // Prevent body scrolling when modal is open
                document.body.style.overflow = 'hidden';
            } else {
                console.error('Modal element not found');
            }
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing feedback modal');
            if (visitFeedbackModal) {
                visitFeedbackModal.classList.add('hidden');
                // Restore body scrolling
                document.body.style.overflow = 'auto';
                // Reset form
                if (visitFeedbackForm) {
                    visitFeedbackForm.reset();
                }

                // Reset stars
                if (ratingStars) {
                    ratingStars.forEach(function (star) {
                        star.querySelector('svg').setAttribute('fill', 'none');
                        star.querySelector('svg').setAttribute('stroke', 'currentColor');
                    });
                }
            }
        }

        // Store functions in global object
        window.visitFeedbackFunctions.open = openModal;
        window.visitFeedbackFunctions.close = closeModal;

        // Star rating functionality
        if (ratingStars) {
            ratingStars.forEach(function (star) {
                star.addEventListener('click', function () {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    document.getElementById('rating').value = rating;

                    // Reset all stars
                    ratingStars.forEach(function (s) {
                        s.querySelector('svg').setAttribute('fill', 'none');
                        s.querySelector('svg').setAttribute('stroke', 'currentColor');
                        s.classList.remove('active');
                    });

                    // Fill in selected stars
                    for (let i = 0; i < ratingStars.length; i++) {
                        const currentStar = ratingStars[i];
                        const starRating = parseInt(currentStar.getAttribute('data-rating'));

                        if (starRating <= rating) {
                            currentStar.querySelector('svg').setAttribute('fill', '#F91D7C');
                            currentStar.querySelector('svg').setAttribute('stroke', '#F91D7C');
                            currentStar.classList.add('active');
                        }
                    }
                });
            });
        }

        // Event Listeners for opening modal
        if (visitFeedbackBtns.length > 0) {
            visitFeedbackBtns.forEach(btn => {
                console.log('Adding click listener to feedback button');
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    console.log('Feedback button clicked');
                    openModal();
                });
            });
        }

        // Event Listeners for closing modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeModal);
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !visitFeedbackModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Form Submission
        if (visitFeedbackForm) {
            // First, let's add code validation
            const appointmentCodeInput = document.getElementById('appointmentCode');
            const feedbackInput = document.getElementById('feedback');
            const ratingInput = document.getElementById('rating');

            // Validate appointment code when it loses focus
            if (appointmentCodeInput) {
                appointmentCodeInput.addEventListener('blur', function () {
                    if (this.value.trim() === '') return;

                    // Show loading indicator
                    this.classList.add('bg-gray-100');

                    // You'll need to ensure the CSRF token is available
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    fetch('/api/validate-appointment-code', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ appointment_code: this.value })
                    })
                        .then(response => response.json())
                        .then(data => {
                            this.classList.remove('bg-gray-100');

                            if (data.valid) {
                                // Show success indicator
                                this.classList.remove('border-red-500');
                                this.classList.add('border-green-500');

                                // Maybe add a small checkmark next to the field
                                const parent = this.parentElement;
                                let checkmark = parent.querySelector('.valid-checkmark');

                                if (!checkmark) {
                                    checkmark = document.createElement('div');
                                    checkmark.className = 'valid-checkmark absolute right-2 top-1/2 transform -translate-y-1/2 text-green-500';
                                    checkmark.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                `;
                                    parent.classList.add('relative');
                                    parent.appendChild(checkmark);
                                }
                            } else {
                                // Show error
                                this.classList.remove('border-green-500');
                                this.classList.add('border-red-500');

                                // Remove checkmark if exists
                                const parent = this.parentElement;
                                const checkmark = parent.querySelector('.valid-checkmark');
                                if (checkmark) parent.removeChild(checkmark);

                                // Show error message
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error validating appointment code:', error);
                            this.classList.remove('bg-gray-100');
                        });
                });
            }

            visitFeedbackForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Get the CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                // Create form data including the token
                const formData = new FormData(this);
                formData.append('_token', csrfToken);

                // Convert to JSON if using fetch with JSON
                const jsonData = {
                    _token: csrfToken,
                    appointment_code: document.getElementById('appointmentCode').value,
                    rating: document.getElementById('rating').value,
                    feedback: document.getElementById('feedback').value
                };

                fetch('/api/submit-feedback', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(jsonData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Thank you for your feedback!');
                            closeModal();
                        } else {
                            alert(data.message || 'Error submitting feedback');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting your feedback');
                    });
            });
        }
    });

    // Add a second event listener that runs after a slight delay to ensure 
    // all elements are fully loaded and processed
    setTimeout(function () {
        const visitFeedbackBtns = document.querySelectorAll('.visitFeedbackBtn');
        console.log('Delayed check - Found feedback buttons:', visitFeedbackBtns.length);

        if (visitFeedbackBtns.length > 0) {
            visitFeedbackBtns.forEach(btn => {
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    console.log('Feedback button clicked (delayed setup)');
                    if (window.visitFeedbackFunctions && window.visitFeedbackFunctions.open) {
                        window.visitFeedbackFunctions.open();
                    } else {
                        console.error('Visit feedback functions not available');
                    }
                });
            });
        }
    }, 1000);
</script>

<style>
    .rating-star.active svg {
        fill: #F91D7C;
        stroke: #F91D7C;
    }

    .valid-checkmark {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>