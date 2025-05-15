{{-- View Allergies Modal --}}
<div id="viewAllergyModal" class="fixed inset-0 z-50 hidden overflow-y-auto"> 
    <div class="flex items-center justify-center min-h-screen px-4"> 
        <!-- Modal Background Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="allergyModalOverlay"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10"> 
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-0">
                <h3 class="text-2xl font-bold">
                    <span class="text-[#F91D7C]">View</span> Allergy
                </h3>

                <button type="button" class="text-gray-400 hover:text-gray-500" id="closeViewAllergyBtn" onclick="closeAllergyModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Allergy Information Display -->
                <div class="space-y-6">
                    <!-- Allergy -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Allergy</h4>
                        <p id="allergyName" class="text-base font-medium text-gray-900">Peanuts</p>
                    </div>

                    <!-- Reaction Severity -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Reaction Severity</h4>
                        <p id="allergySeverity" class="text-base font-medium text-gray-900">Moderate</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                        <p id="allergyNotes" class="text-base text-black whitespace-pre-wrap">Patient experiences hives and difficulty breathing when exposed to peanuts. Patient carries an EpiPen.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Elements
        const viewAllergyModal = document.getElementById('viewAllergyModal');
        const allergyModalOverlay = document.getElementById('allergyModalOverlay');
        const closeViewAllergyBtn = document.getElementById('closeViewAllergyBtn');

        // Find all view buttons with the class
        const viewButtons = document.querySelectorAll('.view-allergy-btn');

        // Add custom scrollbar styles if not already added
        if (!document.getElementById('customScrollbarStyles')) {
            const style = document.createElement('style');
            style.id = 'customScrollbarStyles';
            style.textContent = `
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #ddd;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #ccc;
            }
            `;
            document.head.appendChild(style);
        }

        // Open Modal Function
        function openModal(allergyName, allergySeverity, allergyNotes) {
            console.log('Opening allergy view modal');
            
            // Set display values
            if (allergyName) {
                document.getElementById('allergyName').textContent = allergyName || 'N/A';
            }
            
            if (allergySeverity) {
                document.getElementById('allergySeverity').textContent = allergySeverity || 'N/A';
            }
            
            if (allergyNotes) {
                document.getElementById('allergyNotes').textContent = allergyNotes || 'No notes available';
            }
            
            // Show the modal
            viewAllergyModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal Function
        function closeModal() {
            console.log('Closing allergy view modal');
            viewAllergyModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Add click event to each view button
        viewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get data attributes from the button
                const allergyName = this.getAttribute('data-allergy-name');
                const allergySeverity = this.getAttribute('data-allergy-severity');
                const allergyNotes = this.getAttribute('data-allergy-notes');
                
                // Open the modal with this allergy's data
                openModal(allergyName, allergySeverity, allergyNotes);
                
                console.log('Opening modal for allergy:', allergyName);
            });
        });

        // Event Listeners for modal controls
        if (closeViewAllergyBtn) {
            closeViewAllergyBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
                console.log('Modal closed via X button');
            });
        }

        // Add a global function to close the modal that can be called from inline onclick
        window.closeAllergyModal = function() {
            closeModal();
            console.log('Modal closed via inline onclick handler');
        };

        if (allergyModalOverlay) {
            allergyModalOverlay.addEventListener('click', function (e) {
                e.preventDefault();
                if (e.target === allergyModalOverlay) {
                    closeModal();
                    console.log('Modal closed via overlay');
                }
            });
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !viewAllergyModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Example function to programmatically open the modal (for testing)
        window.openViewAllergyModal = function(allergyName, allergySeverity, allergyNotes) {
            openModal(allergyName, allergySeverity, allergyNotes);
        };
    });
</script>