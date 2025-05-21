<!-- Feedback Details Modal -->
<div id="feedbackModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Feedback</span> Details
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeFeedbackModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex flex-col space-y-4">
                        <!-- Appointment Info -->
                        <div class="border-b pb-2">
                            <h4 class="text-gray-700 text-sm font-medium mb-2">Appointment Details</h4>
                            <p class="text-gray-800"><span class="font-medium">Code:</span> APP-<span
                                    id="feedback-appointment-id"></span></p>
                            <p class="text-gray-800"><span class="font-medium">Date:</span> <span
                                    id="feedback-appointment-date"></span></p>
                            <p class="text-gray-800"><span class="font-medium">Type:</span> <span
                                    id="feedback-appointment-type"></span></p>
                        </div>

                        <!-- Rating Display -->
                        <div class="border-b pb-2">
                            <h4 class="text-gray-700 text-sm font-medium mb-2">Customer Rating</h4>
                            <div class="flex space-x-1" id="feedback-rating-display">
                                <!-- Stars will be added here via JavaScript -->
                            </div>
                        </div>

                        <!-- Feedback Description -->
                        <div>
                            <h4 class="text-gray-700 text-sm font-medium mb-2">Customer Comments</h4>
                            <div class="bg-gray-50 rounded-md p-3" id="feedback-description-display">
                                <!-- Feedback text will be added here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Actions -->
                <div class="mt-4">
                    <button type="button" id="closeFeedbackBtn"
                        class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the feedback modal and its elements
        const feedbackModal = document.getElementById('feedbackModal');
        const closeFeedbackModalBtn = document.getElementById('closeFeedbackModalBtn');
        const closeFeedbackBtn = document.getElementById('closeFeedbackBtn');

        // Function to close feedback modal
        function closeFeedbackModal() {
            if (feedbackModal) {
                feedbackModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // Function to open feedback modal with details
        function openFeedbackDetails(feedbackId) {
            if (!feedbackId) {
                console.error('No feedback ID provided');
                return;
            }

            console.log('Opening feedback details for ID:', feedbackId);

            // Fetch feedback details from the server
            fetch(`/api/feedbacks/${feedbackId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    if (data.success) {
                        // Populate the modal with feedback details
                        populateFeedbackDetails(data.feedback);

                        // Show the modal
                        feedbackModal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    } else {
                        alert('Failed to load feedback details: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error loading feedback details:', error);
                    alert('An error occurred while loading feedback details');
                });
        }

        // Function to populate feedback details in the modal
        function populateFeedbackDetails(feedback) {
            console.log('Populating feedback details:', feedback);

            // Set appointment details
            document.getElementById('feedback-appointment-id').textContent = feedback.appointment_ID;

            // Format the date if it's a string
            let appointmentDate = feedback.appointment.date;
            if (typeof appointmentDate === 'string' && appointmentDate.includes('-')) {
                // Convert YYYY-MM-DD to a more readable format
                const dateObj = new Date(appointmentDate);
                appointmentDate = dateObj.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
            document.getElementById('feedback-appointment-date').textContent = appointmentDate;
            document.getElementById('feedback-appointment-type').textContent = feedback.appointment.appointment_type;

            // Set rating stars
            const ratingDisplay = document.getElementById('feedback-rating-display');
            ratingDisplay.innerHTML = ''; // Clear existing stars

            for (let i = 1; i <= 5; i++) {
                const starSvg = document.createElement('div');

                if (i <= feedback.rating) {
                    // Filled star for ratings
                    starSvg.innerHTML = `
                        <svg class="w-6 h-6 text-[#F91D7C]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    `;
                } else {
                    // Empty star for remaining
                    starSvg.innerHTML = `
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    `;
                }

                ratingDisplay.appendChild(starSvg);
            }

            // Set feedback description
            const descriptionDisplay = document.getElementById('feedback-description-display');
            descriptionDisplay.textContent = feedback.description || 'No comments provided';
        }

        // Add event handlers for modal controls
        if (closeFeedbackModalBtn) closeFeedbackModalBtn.addEventListener('click', closeFeedbackModal);
        if (closeFeedbackBtn) closeFeedbackBtn.addEventListener('click', closeFeedbackModal);

        // Expose methods to window for external access
        window.feedbackFunctions = {
            open: openFeedbackDetails,
            close: closeFeedbackModal
        };

        console.log('Feedback modal functions initialized');
    });
</script>