document.addEventListener('DOMContentLoaded', function () {
    console.log('Appointments JS loaded');
    
    // Store the current state
    const state = {
        currentStatus: 'today',     // Default status
        currentTab: 'consultation'  // Default tab
    };

    // DOM Elements
    const statusCards = document.querySelectorAll('.status-card');
    const tabButtons = document.querySelectorAll('.tab-button');
    const appointmentList = document.getElementById('appointment-list');
    const appointmentCards = document.getElementById('appointment-cards');
    const paginationContainer = document.querySelector('.pagination-container');
    
    console.log('Found status cards:', statusCards.length);
    console.log('Found tab buttons:', tabButtons.length);

    // Add click handlers to status cards
    statusCards.forEach(card => {
        card.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            console.log('Status card clicked:', status);
            
            // Update state
            state.currentStatus = status;
            
            // Update UI - highlight active card
            statusCards.forEach(c => {
                c.classList.remove('bg-amber-50', 'bg-blue-50', 'bg-pink-50', 'bg-green-50', 'bg-red-50');
                c.classList.add('bg-white');
            });
            
            // Set the background based on status
            const bgMap = {
                'pending': 'bg-amber-50',
                'today': 'bg-blue-50',
                'upcoming': 'bg-pink-50',
                'completed': 'bg-green-50',
                'cancelled': 'bg-red-50'
            };
            
            this.classList.remove('bg-white');
            this.classList.add(bgMap[status]);
            
            // Fetch appointments with new filter
            fetchAppointments();
        });
    });

    // Add click handlers to tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tab = this.getAttribute('data-tab');
            console.log('Tab clicked:', tab);
            
            // Update state
            state.currentTab = tab;
            
            // Update UI - highlight active tab
            tabButtons.forEach(t => {
                t.classList.remove('text-[#F91D7C]');
                t.classList.add('text-gray-800');
                
                // Remove indicator
                const indicator = t.querySelector('div');
                if (indicator) indicator.remove();
            });
            
            // Highlight this tab
            this.classList.remove('text-gray-800');
            this.classList.add('text-[#F91D7C]');
            
            // Add indicator
            const indicator = document.createElement('div');
            indicator.className = 'absolute bottom-0 left-0 h-0.5 w-full bg-[#F91D7C]';
            this.appendChild(indicator);
            
            // Fetch appointments with new filter
            fetchAppointments();
        });
    });

    // Function to fetch appointments
    function fetchAppointments(page = 1) {
        console.log('Fetching appointments with filters:', { status: state.currentStatus, tab: state.currentTab, page });
        
        // Show loading state
        if (appointmentList) {
            appointmentList.innerHTML = '<tr><td colspan="5" class="py-5 text-center">Loading appointments...</td></tr>';
        }
        if (appointmentCards) {
            appointmentCards.innerHTML = '<div class="p-4 text-center">Loading appointments...</div>';
        }
        
        // AJAX request to get filtered appointments
        fetch(`/appointments/filter?status=${state.currentStatus}&type=${state.currentTab}&page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Appointments data received:', data);
            
            // Render appointments
            renderAppointments(data.appointments.data);
            
            // Update pagination if present
            if (paginationContainer) {
                renderPagination(data.pagination);
            }
        })
        .catch(error => {
            console.error('Error fetching appointments:', error);
            
            // Show error message
            if (appointmentList) {
                appointmentList.innerHTML = '<tr><td colspan="5" class="py-5 text-center text-red-500">Error loading appointments. Please try again.</td></tr>';
            }
            if (appointmentCards) {
                appointmentCards.innerHTML = '<div class="p-4 text-center text-red-500">Error loading appointments. Please try again.</div>';
            }
        });
    }

    // Function to render appointments
    function renderAppointments(appointments) {
        if (!appointmentList && !appointmentCards) return;
        
        if (appointments.length === 0) {
            // No appointments to show
            if (appointmentList) {
                appointmentList.innerHTML = '<tr><td colspan="5" class="py-5 text-center text-gray-500">No appointments found</td></tr>';
            }
            if (appointmentCards) {
                appointmentCards.innerHTML = '<div class="p-4 text-center text-gray-500">No appointments found</div>';
            }
            return;
        }
        
        // Clear existing content
        if (appointmentList) appointmentList.innerHTML = '';
        if (appointmentCards) appointmentCards.innerHTML = '';
        
        // Loop through appointments
        appointments.forEach(appointment => {
            // Format date and time
            const date = new Date(appointment.date);
            const formattedDate = date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            // For desktop table
            if (appointmentList) {
                const row = document.createElement('tr');
                row.className = 'border-t border-gray-100';
                
                row.innerHTML = `
                    <td class="py-5">${appointment.first_name} ${appointment.last_name}</td>
                    <td class="py-5">${formattedDate}</td>
                    <td class="py-5">${formatTime(appointment.time)}</td>
                    <td class="py-5">${appointment.appointment_type}</td>
                    <td class="py-5 text-right">
                        <div class="flex justify-end space-x-2">
                            ${renderActionButtons(appointment)}
                        </div>
                    </td>
                `;
                
                appointmentList.appendChild(row);
            }
            
            // For mobile cards
            if (appointmentCards) {
                const card = document.createElement('div');
                card.className = 'border border-gray-200 rounded-lg p-4 mb-4';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-normal">${appointment.first_name} ${appointment.last_name}</h3>
                        <div class="flex space-x-2">
                            ${renderActionButtons(appointment, true)}
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <p class="text-gray-500">Date</p>
                            <p>${formattedDate}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Time</p>
                            <p>${formatTime(appointment.time)}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500">Type</p>
                            <p>${appointment.appointment_type}</p>
                        </div>
                        ${appointment.status === 'completed' || appointment.status === 'cancelled' ? `
                        <div class="col-span-2 mt-1">
                            <span class="inline-block px-3 py-1 ${appointment.status === 'completed' ? 'bg-[#2CA74D]/30 text-green-800' : 'bg-[#D11313]/30 text-red-800'} rounded-lg text-xs">
                                ${appointment.status}
                            </span>
                        </div>` : ''}
                    </div>
                `;
                
                appointmentCards.appendChild(card);
            }
        });
        
        // Attach action button handlers
        attachActionButtonHandlers();
    }
    
    // Helper function to format time string
    function formatTime(timeString) {
        if (!timeString) return '';
        
        try {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours, 10);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes} ${ampm}`;
        } catch (e) {
            console.error('Error formatting time:', e);
            return timeString;
        }
    }
    
    // Function to render action buttons
    function renderActionButtons(appointment, isMobile = false) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        const appointmentDate = new Date(appointment.date);
        appointmentDate.setHours(0, 0, 0, 0);
        
        if (appointment.status === 'pending') {
            return `
                <button class="text-green-600 approve-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/check_icon.svg" alt="Approve">
                </button>
                <button class="text-red-600 cancel-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/xmark_icon.svg" alt="Cancel">
                </button>
            `;
        } else if (appointmentDate.getTime() === today.getTime()) {
            return `
                <button class="text-[#F91D7C] complete-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/check_icon.svg" alt="Done">
                </button>
                <button class="text-[#F91D7C] reschedule-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/reschedule_icon.svg" alt="Reschedule">
                </button>
                <button class="text-red-600 cancel-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/xmark_icon.svg" alt="Cancel">
                </button>
            `;
        } else if (appointmentDate.getTime() > today.getTime()) {
            return `
                <button class="text-[#F91D7C] reschedule-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/reschedule_icon.svg" alt="Reschedule">
                </button>
                <button class="text-red-600 cancel-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/xmark_icon.svg" alt="Cancel">
                </button>
            `;
        } else {
            return `
                <span class="inline-block px-4 py-1 ${appointment.status === 'completed' ? 'bg-[#2CA74D]/30 text-green-800' : 'bg-[#D11313]/30 text-red-800'} rounded-lg text-sm">
                    ${appointment.status}
                </span>
            `;
        }
    }
    
    // Function to render pagination
    function renderPagination(pagination) {
        if (!paginationContainer) return;
        
        let paginationHtml = '';
        
        if (pagination.last_page > 1) {
            paginationHtml += `
                <div class="flex space-x-1">
                    <button class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500 ${pagination.current_page === 1 ? 'opacity-50 cursor-not-allowed' : ''}" 
                        ${pagination.current_page === 1 ? 'disabled' : ''} 
                        onclick="${pagination.current_page === 1 ? '' : `changePage(${pagination.current_page - 1})`}">
                        Previous
                    </button>
            `;
            
            // Show at most 5 pages
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.last_page, startPage + 4);
            
            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `
                    <button class="w-8 h-8 flex items-center justify-center ${i === pagination.current_page ? 'bg-[#F91D7C] text-white' : 'border border-gray-200'} rounded text-sm"
                        onclick="changePage(${i})">
                        ${i}
                    </button>
                `;
            }
            
            paginationHtml += `
                    <button class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500 ${pagination.current_page === pagination.last_page ? 'opacity-50 cursor-not-allowed' : ''}"
                        ${pagination.current_page === pagination.last_page ? 'disabled' : ''}
                        onclick="${pagination.current_page === pagination.last_page ? '' : `changePage(${pagination.current_page + 1})`}">
                        Next
                    </button>
                </div>
            `;
        }
        
        paginationContainer.innerHTML = paginationHtml;
    }
    
    // Function to change pagination page
    window.changePage = function(page) {
        fetchAppointments(page);
    };
    
    // Function to attach handlers to action buttons
    function attachActionButtonHandlers() {
        // Approve buttons
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                updateAppointmentStatus(id, 'pending', 'upcoming');
            });
        });
        
        // Complete buttons
        document.querySelectorAll('.complete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                updateAppointmentStatus(id, 'upcoming', 'completed');
            });
        });
        
        // Reschedule buttons
        document.querySelectorAll('.reschedule-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                alert('Reschedule functionality will be implemented later.');
            });
        });
        
        // Cancel buttons
        document.querySelectorAll('.cancel-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to cancel this appointment?')) {
                    updateAppointmentStatus(id, '', 'cancelled');
                }
            });
        });
    }
    
    // Function to update appointment status
    function updateAppointmentStatus(id, fromStatus, toStatus) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            alert('Security token not found. Please refresh the page and try again.');
            return;
        }
        
        fetch(`/appointments/${id}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: toStatus
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Status updated successfully');
                
                // Refresh appointment list
                fetchAppointments();
                
                // Update status counts
                updateStatusCounts();
            } else {
                alert('Failed to update appointment status');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            alert('An error occurred while updating appointment status');
        });
    }
    
    // Function to update status counts
    function updateStatusCounts() {
        fetch('/appointments/counts', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Status counts updated:', data);
            
            // Update count in each status card
            statusCards.forEach(card => {
                const status = card.getAttribute('data-status');
                const countElement = card.querySelector('p:last-child');
                if (countElement && data[status + 'Count'] !== undefined) {
                    countElement.textContent = data[status + 'Count'];
                }
            });
        })
        .catch(error => {
            console.error('Error updating status counts:', error);
        });
    }
    
    // Fetch appointments on page load
    fetchAppointments();
});