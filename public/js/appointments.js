document.addEventListener('DOMContentLoaded', function () {
    console.log('Appointments JS loaded');
    
    // Store the current state
    const state = {
        currentStatus: 'today',     // Default status
        currentTab: 'consultation'  // Default tab
    };

    // DOM Elements
    const elements = {
        statusCards: document.querySelectorAll('.status-card'),
        tabButtons: document.querySelectorAll('.tab-button'),
        tableBody: document.getElementById('appointment-list'),
        cardsContainer: document.getElementById('appointment-cards'),
        paginationContainer: document.querySelector('.pagination-container')
    };
    
    // Add click handlers to status cards
    elements.statusCards.forEach(card => {
        card.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            
            // Update state
            state.currentStatus = status;
            
            // Reset all cards
            elements.statusCards.forEach(c => {
                c.classList.remove('bg-amber-50', 'bg-blue-50', 'bg-pink-50', 'bg-green-50', 'bg-red-50');
                c.classList.add('bg-white');
            });
            
            // Set active card background
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
    elements.tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tab = this.getAttribute('data-tab');
            
            // Update state
            state.currentTab = tab;
            
            // Reset all tabs
            elements.tabButtons.forEach(t => {
                t.classList.remove('text-[#F91D7C]');
                t.classList.add('text-gray-800');
                const indicator = t.querySelector('div');
                if (indicator) indicator.remove();
            });
            
            // Set active tab
            this.classList.remove('text-gray-800');
            this.classList.add('text-[#F91D7C]');
            const indicator = document.createElement('div');
            indicator.className = 'absolute bottom-0 left-0 h-0.5 w-full bg-[#F91D7C]';
            this.appendChild(indicator);
            
            // Fetch appointments with new filter
            fetchAppointments();
        });
    });

    // Function to fetch appointments
    function fetchAppointments(page = 1) {
        console.log('Fetching appointments...', { status: state.currentStatus, type: state.currentTab, page });

        // Show loading state
        showLoadingState();
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // AJAX request
        fetch(`/appointments/filter?status=${state.currentStatus}&type=${state.currentTab}&page=${page}`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Appointments data:', data);
            renderAppointments(data.appointments.data);
            if (elements.paginationContainer) {
                renderPagination(data.pagination);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Failed to load appointments. Please try again.');
        });
    }

    // Function to show loading state
    function showLoadingState() {
        const loadingMessage = '<tr><td colspan="5" class="py-5 text-center">Loading appointments...</td></tr>';
        if (elements.tableBody) elements.tableBody.innerHTML = loadingMessage;
        if (elements.cardsContainer) elements.cardsContainer.innerHTML = '<div class="p-4 text-center">Loading appointments...</div>';
    }

    // Function to show error
    function showError(message) {
        if (elements.tableBody) {
            elements.tableBody.innerHTML = `<tr><td colspan="5" class="py-5 text-center text-red-500">${message}</td></tr>`;
        }
        if (elements.cardsContainer) {
            elements.cardsContainer.innerHTML = `<div class="p-4 text-center text-red-500">${message}</div>`;
        }
    }

    // Function to render appointments
    function renderAppointments(appointments) {
        if (!appointments || appointments.length === 0) {
            showError('No appointments found');
            return;
        }

        // Clear existing content
        if (elements.tableBody) elements.tableBody.innerHTML = '';
        if (elements.cardsContainer) elements.cardsContainer.innerHTML = '';

        appointments.forEach(appointment => {
            renderAppointmentRow(appointment);
            renderAppointmentCard(appointment);
        });

        // Attach handlers to new buttons
        attachActionButtonHandlers();
    }

    // Function to render a table row
    function renderAppointmentRow(appointment) {
        if (!elements.tableBody) return;

        const row = document.createElement('tr');
        row.className = 'border-t border-gray-100';
        
        const formattedDate = formatDate(appointment.date);
        const formattedTime = formatTime(appointment.time);

        row.innerHTML = `
            <td class="py-5">${appointment.first_name} ${appointment.last_name}</td>
            <td class="py-5">${formattedDate}</td>
            <td class="py-5">${formattedTime}</td>
            <td class="py-5">${appointment.appointment_type}</td>
            <td class="py-5 text-right">
                <div class="flex justify-end space-x-2">
                    ${renderActionButtons(appointment)}
                </div>
            </td>
        `;

        elements.tableBody.appendChild(row);
    }

    // Function to render a mobile card
    function renderAppointmentCard(appointment) {
        if (!elements.cardsContainer) return;

        const card = document.createElement('div');
        card.className = 'border border-gray-200 rounded-lg p-4 mb-4';
        
        const formattedDate = formatDate(appointment.date);
        const formattedTime = formatTime(appointment.time);

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
                    <p>${formattedTime}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-500">Type</p>
                    <p>${appointment.appointment_type}</p>
                </div>
                ${getStatusBadge(appointment)}
            </div>
        `;

        elements.cardsContainer.appendChild(card);
    }

    // Helper function for date formatting
    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    // Helper function for time formatting
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

    // Helper function for status badge
    function getStatusBadge(appointment) {
        if (appointment.status === 'completed' || appointment.status === 'cancelled') {
            const colorClass = appointment.status === 'completed' ? 
                'bg-[#2CA74D]/30 text-green-800' : 
                'bg-[#D11313]/30 text-red-800';
            return `
                <div class="col-span-2 mt-1">
                    <span class="inline-block px-3 py-1 ${colorClass} rounded-lg text-xs">
                        ${appointment.status}
                    </span>
                </div>
            `;
        }
        return '';
    }

    // Function to render action buttons
    function renderActionButtons(appointment, isMobile = false) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        const appointmentDate = new Date(appointment.date);
        appointmentDate.setHours(0, 0, 0, 0);
        
        if (appointment.status === 'pending') {
            return `
                <button type="button" class="text-green-600 approve-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/check_icon.svg" alt="Approve">
                </button>
                <button type="button" class="text-red-600 cancel-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/xmark_icon.svg" alt="Cancel">
                </button>
            `;
        } else if (appointmentDate.getTime() === today.getTime()) {
            return `
                <button type="button" class="text-[#F91D7C] complete-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/check_icon.svg" alt="Done">
                </button>
                <button type="button" class="text-[#F91D7C] reschedule-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/reschedule_icon.svg" alt="Reschedule">
                </button>
                <button type="button" class="text-red-600 cancel-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/xmark_icon.svg" alt="Cancel">
                </button>
            `;
        } else if (appointmentDate.getTime() > today.getTime()) {
            return `
                <button type="button" class="text-[#F91D7C] reschedule-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/reschedule_icon.svg" alt="Reschedule">
                </button>
                <button type="button" class="text-red-600 cancel-btn" data-id="${appointment.appointment_ID}">
                    <img src="/icons/xmark_icon.svg" alt="Cancel">
                </button>
            `;
        } 
        return `
            <span class="inline-block px-4 py-1 ${appointment.status === 'completed' ? 'bg-[#2CA74D]/30 text-green-800' : 'bg-[#D11313]/30 text-red-800'} rounded-lg text-sm">
                ${appointment.status}
            </span>
        `;
    }

    // Function to attach action button handlers
    function attachActionButtonHandlers() {        // Approve functionality
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to approve this appointment?')) {
                    updateAppointmentStatus(id, 'upcoming');
                }
            });
        });// Complete functionality
        document.querySelectorAll('.complete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to mark this appointment as completed?')) {
                    updateAppointmentStatus(id, 'completed');
                }
            });
        });

        // Reschedule functionality
        document.querySelectorAll('.reschedule-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (window.rescheduleFunctions && window.rescheduleFunctions.open) {
                    window.rescheduleFunctions.open();
                } else {
                    showRescheduleModal(id);
                }
            });
        });

        // Cancel functionality
        document.querySelectorAll('.cancel-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to cancel this appointment?')) {
                    updateAppointmentStatus(id, 'cancelled');
                }
            });
        });
    }    // Function to update appointment status
    function updateAppointmentStatus(id, newStatus) {
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
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Failed to update status');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                const message = {
                    'upcoming': 'Appointment approved successfully',
                    'completed': 'Appointment marked as completed',
                    'cancelled': 'Appointment cancelled successfully'
                }[newStatus] || 'Status updated successfully';
                
                alert(message);

                // Refresh appointments and counts
                fetchAppointments();
                updateStatusCounts();
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Failed to update appointment status. Please try again.');
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
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Update count in each status card
            elements.statusCards.forEach(card => {
                const status = card.getAttribute('data-status');
                const countElement = card.querySelector('p:last-child');
                if (countElement && data[`${status}Count`] !== undefined) {
                    countElement.textContent = data[`${status}Count`];
                }
            });
        })
        .catch(error => {
            console.error('Error updating counts:', error);
        });
    }

    // Function to render pagination
    function renderPagination(pagination) {
        if (!elements.paginationContainer) return;
        
        let html = '';
        if (pagination.last_page > 1) {
            html += `
                <div class="flex space-x-1">
                    <button 
                        type="button"
                        class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500 ${pagination.current_page === 1 ? 'opacity-50 cursor-not-allowed' : ''}" 
                        ${pagination.current_page === 1 ? 'disabled' : ''}
                        onclick="changePage(${pagination.current_page - 1})"
                    >
                        Previous
                    </button>
            `;

            // Show up to 5 pages
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.last_page, startPage + 4);

            for (let i = startPage; i <= endPage; i++) {
                html += `
                    <button 
                        type="button"
                        class="w-8 h-8 flex items-center justify-center ${i === pagination.current_page ? 'bg-[#F91D7C] text-white' : 'border border-gray-200'} rounded text-sm"
                        onclick="changePage(${i})"
                    >
                        ${i}
                    </button>
                `;
            }

            html += `
                    <button 
                        type="button"
                        class="px-3 py-1 text-sm border border-gray-200 rounded text-gray-500 ${pagination.current_page === pagination.last_page ? 'opacity-50 cursor-not-allowed' : ''}"
                        ${pagination.current_page === pagination.last_page ? 'disabled' : ''}
                        onclick="changePage(${pagination.current_page + 1})"
                    >
                        Next
                    </button>
                </div>
            `;
        }

        elements.paginationContainer.innerHTML = html;
    }

    // Global function for pagination
    window.changePage = function(page) {
        fetchAppointments(page);
    };

    // Initial load
    fetchAppointments();
});
