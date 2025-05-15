<!-- Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-black/70 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">Rate</span> your experience
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeFeedbackModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="feedbackForm">
                    @csrf
                    <input type="hidden" id="feedback_appointment_id" name="appointment_ID">
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2">How would you rate your experience?</label>
                        <div class="flex space-x-4 justify-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="rating-option">
                                    <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="hidden" {{ $i == 5 ? 'checked' : '' }}>
                                    <label for="rating-{{ $i }}" class="cursor-pointer">
                                        <svg class="w-10 h-10 text-gray-300 hover:text-[#F91D7C] transition-colors rating-star" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="feedback-description" class="block text-gray-700 text-sm font-medium mb-2">Tell us about your experience (optional)</label>
                        <textarea 
                            id="feedback-description" 
                            name="description" 
                            rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F91D7C] focus:border-transparent" 
                            placeholder="Share your thoughts..."></textarea>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="w-full py-3 bg-[#F91D7C] hover:bg-[#e01a70] text-white font-medium rounded-md transition-colors">
                            Submit
                        </button>
                        <button type="button" id="cancelFeedbackBtn" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-medium rounded-md transition-colors">
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
    // Get the feedback modal and its elements
    const feedbackModal = document.getElementById('feedbackModal');
    const closeFeedbackModalBtn = document.getElementById('closeFeedbackModalBtn');
    const cancelFeedbackBtn = document.getElementById('cancelFeedbackBtn');
    const feedbackForm = document.getElementById('feedbackForm');
    const ratingOptions = document.querySelectorAll('.rating-option input');
    const ratingStars = document.querySelectorAll('.rating-star');
    
    // Function to open feedback modal
    function openFeedbackModal() {
        if (feedbackModal) {
            feedbackModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Function to close feedback modal
    function closeFeedbackModal() {
        if (feedbackModal) {
            feedbackModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (feedbackForm) feedbackForm.reset();
            resetStars();
        }
    }
    
    // Function to highlight stars based on selection
    function highlightStars(rating) {
        ratingStars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('text-[#F91D7C]');
                star.classList.remove('text-gray-300');
            } else {
                star.classList.remove('text-[#F91D7C]');
                star.classList.add('text-gray-300');
            }
        });
    }
    
    // Function to reset star highlights
    function resetStars() {
        ratingStars.forEach(star => {
            star.classList.remove('text-[#F91D7C]');
            star.classList.add('text-gray-300');
        });
        
        // Reset selected radio button
        ratingOptions.forEach((option, index) => {
            if (index === 4) { // 5-star rating
                option.checked = true;
                highlightStars(5);
            } else {
                option.checked = false;
            }
        });
    }
    
    // Add event handlers for modal controls
    if (closeFeedbackModalBtn) closeFeedbackModalBtn.addEventListener('click', closeFeedbackModal);
    if (cancelFeedbackBtn) cancelFeedbackBtn.addEventListener('click', closeFeedbackModal);
    
    // Add event handlers for star rating
    ratingOptions.forEach((option, index) => {
        option.addEventListener('change', function() {
            highlightStars(index + 1);
        });
        
        // Also highlight on hover
        option.parentElement.addEventListener('mouseenter', function() {
            highlightStars(index + 1);
        });
        
        option.parentElement.addEventListener('mouseleave', function() {
            // On mouseleave, highlight only the selected rating
            const selectedRating = document.querySelector('.rating-option input:checked');
            if (selectedRating) {
                highlightStars(parseInt(selectedRating.value));
            } else {
                resetStars();
            }
        });
    });
    
    // Handle form submission
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("feedbacks.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thank you for your feedback!');
                    closeFeedbackModal();
                } else {
                    alert('Failed to submit feedback. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error submitting feedback:', error);
                alert('An error occurred while submitting your feedback');
            });
        });
    }
    
    // Set default rating (5 stars)
    resetStars();
    
    // Expose methods to window for external access
    window.feedbackFunctions = {
        open: openFeedbackModal,
        close: closeFeedbackModal
    };
});
</script>