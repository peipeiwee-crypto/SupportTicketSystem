let token = localStorage.getItem('token');
let currentUser = null;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    if (token) {
        validateToken();
    } else {
        showSection('loginSection');
    }
});

async function validateToken() {
    try {
        const response = await fetch('/api/user', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            currentUser = data.data;
            updateAuthUI();
            showSection('ticketsSection');
            loadTickets();
            loadAllTickets();
        } else {
            logout();
        }
    } catch (error) {
        logout();
    }
}

function updateAuthUI() {
    document.getElementById('loginBtn').style.display = 'none';
    document.getElementById('registerBtn').style.display = 'none';
    document.getElementById('logoutBtn').style.display = 'block';
    document.getElementById('userInfo').style.display = 'block';
    document.getElementById('userInfo').textContent = `Welcome, ${currentUser.name}`;
}

function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
}

function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    if (tabName === 'myTickets') {
        document.getElementById('myTicketsTab').classList.add('active');
        loadTickets();
    } else if (tabName === 'allTickets') {
        document.getElementById('allTicketsTab').classList.add('active');
        loadAllTickets();
    }
}

function showLogin() {
    showSection('loginSection');
}

function showRegister() {
    showSection('registerSection');
}

async function login(event) {
    event.preventDefault();
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (data.success) {
            token = data.data.token;
            currentUser = data.data.user;
            localStorage.setItem('token', token);
            updateAuthUI();
            showSection('ticketsSection');
            loadTickets();
            loadAllTickets();
            document.getElementById('loginAlert').innerHTML = '';
        } else {
            showAlert('loginAlert', data.message || 'Login failed', 'error');
        }
    } catch (error) {
        showAlert('loginAlert', 'An error occurred', 'error');
    }
}

async function register(event) {
    event.preventDefault();
    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;
    const password_confirmation = document.getElementById('registerPasswordConfirm').value;

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name, email, password, password_confirmation })
        });

        const data = await response.json();

        if (data.success) {
            token = data.data.token;
            currentUser = data.data.user;
            localStorage.setItem('token', token);
            updateAuthUI();
            showSection('ticketsSection');
            loadTickets();
            loadAllTickets();
        } else {
            const errors = data.errors ? Object.values(data.errors).flat().join(', ') : data.message;
            showAlert('registerAlert', errors, 'error');
        }
    } catch (error) {
        showAlert('registerAlert', 'An error occurred', 'error');
    }
}

function logout() {
    localStorage.removeItem('token');
    token = null;
    currentUser = null;
    document.getElementById('loginBtn').style.display = 'block';
    document.getElementById('registerBtn').style.display = 'block';
    document.getElementById('logoutBtn').style.display = 'none';
    document.getElementById('userInfo').style.display = 'none';
    showSection('loginSection');
}

async function loadTickets() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const priority = document.getElementById('priorityFilter').value;
    const page = new URLSearchParams(window.location.search).get('page') || 1;

    let url = `/api/tickets?page=${page}`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    if (status) url += `&status=${status}`;
    if (priority) url += `&priority=${priority}`;

    try {
        const response = await fetch(url, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        if (result.success) {
            displayTickets(result.data); // ← Now pass the full pagination object
        }
    } catch (error) {
        console.error('Error loading tickets:', error);
    }
}

function goToPage(page) {
    const params = new URLSearchParams(window.location.search);
    params.set('page', page);
    window.history.pushState({}, '', `${window.location.pathname}?${params}`);
    
    // Reload tickets depending on active tab
    if (document.getElementById('myTicketsTab').classList.contains('active')) {
        loadTickets();
    } else {
        loadAllTickets();
    }
}

function renderPagination(pagination, containerId) {
    const container = document.getElementById(containerId);
    let buttons = '';

    const start = Math.max(1, pagination.current_page - 2);
    const end = Math.min(pagination.last_page, pagination.current_page + 2);

    for (let i = start; i <= end; i++) {
        buttons += `
            <button class="btn ${i === pagination.current_page ? 'btn-primary' : 'btn-secondary'}"
                    onclick="goToPage(${i})">${i}</button>
        `;
    }

    container.innerHTML = `
        <div class="pagination" style="margin-top:20px; text-align:center;">
            ${pagination.current_page > 1 
                ? `<button onclick="goToPage(1)">« First</button>
                   <button onclick="goToPage(${pagination.current_page - 1})">Prev</button>` 
                : ''}
            ${buttons}
            ${pagination.current_page < pagination.last_page 
                ? `<button onclick="goToPage(${pagination.current_page + 1})">Next</button>
                   <button onclick="goToPage(${pagination.last_page})">Last »</button>` 
                : ''}
        </div>
    `;
}



function displayTickets(pagination) {
    const tickets = pagination.data;
    const container = document.getElementById('ticketsContainer');

    if (tickets.length === 0) {
        container.innerHTML = `<div class="empty-state">No tickets found</div>`;
        return;
    }

    container.innerHTML = `
        <div class="ticket-grid">
            ${tickets.map(ticket => `
                <div class="ticket-card" onclick="viewTicket(${ticket.id})">
                    <div class="ticket-header">
                        <div class="ticket-title">${ticket.title}</div>
                        <span class="badge badge-${ticket.priority}">${ticket.priority}</span>
                        <span class="badge badge-${ticket.status}">${ticket.status.replace('_', ' ')}</span>
                    </div>
                    <div class="ticket-description">${ticket.description}</div>
                    <div class="ticket-footer">
                        <span>Comments: ${ticket.comments.length}</span>
                        <span>${new Date(ticket.created_at).toLocaleDateString()}</span>
                    </div>
                </div>
            `).join('')}
        </div>
        <div id="ticketsPagination"></div>
    `;

    // 🔑 Call your pagination renderer here
    renderPagination(pagination, 'ticketsPagination');
}


async function loadAllTickets() {
    const search = document.getElementById('searchAllInput')?.value || '';
    const status = document.getElementById('statusAllFilter')?.value || '';
    const priority = document.getElementById('priorityAllFilter')?.value || '';
    const page = new URLSearchParams(window.location.search).get('page') || 1;

    let url = `/api/tickets/all?page=${page}`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    if (status) url += `&status=${status}`;
    if (priority) url += `&priority=${priority}`;

    try {
        const response = await fetch(url, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        if (result.success) {
            displayAllTickets(result.data);
        }
    } catch (error) {
        console.error('Error loading all tickets:', error);
    }
}

function displayAllTickets(pagination) {
    const tickets = pagination.data;
    const container = document.getElementById('allTicketsContainer');
    
    if (tickets.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3>No tickets found</h3>
            </div>
        `;
        return;
    }

    container.innerHTML = `
        <div class="ticket-grid">
            ${tickets.map(ticket => `
                <div class="ticket-card" onclick="viewTicket(${ticket.id})">
                    <div class="ticket-header">
                        <div>
                            <div class="ticket-title">${ticket.title}</div>
                            <div style="font-size: 0.85rem; color: #999; margin: 5px 0;">
                                Created by: ${ticket.creator.name}
                            </div>
                            <span class="badge badge-${ticket.priority}">${ticket.priority}</span>
                            <span class="badge badge-${ticket.status}">${ticket.status.replace('_', ' ')}</span>
                        </div>
                    </div>
                    <div class="ticket-description">${ticket.description}</div>
                    <div class="ticket-footer">
                        <span>💬 ${ticket.comments.length} comments</span>
                        <span>${new Date(ticket.created_at).toLocaleDateString()}</span>
                    </div>
                </div>
            `).join('')}
        </div>
        <div id="allTicketsPagination"></div>
    `;

    // 🔑 Call your pagination renderer here
    renderPagination(pagination, 'allTicketsPagination');
}


function showCreateTicket() {
    document.getElementById('ticketModalTitle').textContent = 'Create New Ticket';
    document.getElementById('ticketId').value = '';
    document.getElementById('ticketTitle').value = '';
    document.getElementById('ticketDescription').value = '';
    document.getElementById('ticketPriority').value = 'medium';
    document.getElementById('statusGroup').style.display = 'none';
    document.getElementById('ticketModal').classList.add('active');
}

async function viewTicket(ticketId) {
    try {
        const response = await fetch(`/api/tickets/${ticketId}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            displayTicketDetails(data.data);
            document.getElementById('viewTicketModal').classList.add('active');
        }
    } catch (error) {
        console.error('Error loading ticket:', error);
    }
}

function displayTicketDetails(ticket) {
    const content = document.getElementById('viewTicketContent');
    const isOwner = ticket.created_by === currentUser.id;
    
    content.innerHTML = `
        <div style="margin-bottom: 20px;">
            <h3>${ticket.title}</h3>
            <div style="margin: 10px 0;">
                <span class="badge badge-${ticket.priority}">${ticket.priority}</span>
                <span class="badge badge-${ticket.status}">${ticket.status.replace('_', ' ')}</span>
            </div>
            <p style="color: #999; font-size: 0.9rem; margin: 5px 0;">
                Created by: ${ticket.creator.name}
            </p>
            <p style="color: #666; margin-top: 15px;">${ticket.description}</p>
            <p style="color: #999; font-size: 0.9rem; margin-top: 10px;">
                Created: ${new Date(ticket.created_at).toLocaleString()}
            </p>
        </div>

        ${isOwner ? `
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="editTicket(${ticket.id})">Edit</button>
            <button class="btn btn-danger" onclick="deleteTicket(${ticket.id})">Delete</button>
        </div>
        ` : ''}

        <div class="comment-section">
            <h3>Comments (${ticket.comments.length})</h3>
            <div style="margin: 20px 0;">
                ${ticket.comments.map(comment => `
                    <div class="comment">
                        <div class="comment-header">
                            <span class="comment-user">${comment.user.name}</span>
                            <span class="comment-time">${new Date(comment.created_at).toLocaleString()}</span>
                        </div>
                        <p>${comment.message}</p>
                    </div>
                `).join('')}
            </div>
            
            <form onsubmit="addComment(event, ${ticket.id})">
                <div class="form-group">
                    <label>Add a Comment</label>
                    <textarea id="commentMessage" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        </div>
    `;
}

async function editTicket(ticketId) {
    closeViewModal();
    
    try {
        const response = await fetch(`/api/tickets/${ticketId}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            const ticket = data.data;
            document.getElementById('ticketModalTitle').textContent = 'Edit Ticket';
            document.getElementById('ticketId').value = ticket.id;
            document.getElementById('ticketTitle').value = ticket.title;
            document.getElementById('ticketDescription').value = ticket.description;
            document.getElementById('ticketPriority').value = ticket.priority;
            document.getElementById('ticketStatus').value = ticket.status;
            document.getElementById('statusGroup').style.display = 'block';
            document.getElementById('ticketModal').classList.add('active');
        }
    } catch (error) {
        console.error('Error loading ticket:', error);
    }
}

async function saveTicket(event) {
    event.preventDefault();
    
    const ticketId = document.getElementById('ticketId').value;
    const title = document.getElementById('ticketTitle').value;
    const description = document.getElementById('ticketDescription').value;
    const priority = document.getElementById('ticketPriority').value;
    const status = document.getElementById('ticketStatus').value;

    const url = ticketId ? `/api/tickets/${ticketId}` : '/api/tickets';
    const method = ticketId ? 'PUT' : 'POST';

    const body = { title, description, priority };
    if (ticketId && status) body.status = status;

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        });

        const data = await response.json();

        if (data.success) {
            closeTicketModal();
            loadTickets();
            loadAllTickets();
        } else {
            const errors = data.errors ? Object.values(data.errors).flat().join(', ') : data.message;
            showAlert('ticketAlert', errors, 'error');
        }
    } catch (error) {
        showAlert('ticketAlert', 'An error occurred', 'error');
    }
}

async function deleteTicket(ticketId) {
    if (!confirm('Are you sure you want to delete this ticket?')) return;

    try {
        const response = await fetch(`/api/tickets/${ticketId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            closeViewModal();
            loadTickets();
            loadAllTickets();
        }
    } catch (error) {
        console.error('Error deleting ticket:', error);
    }
}

async function addComment(event, ticketId) {
    event.preventDefault();
    const message = document.getElementById('commentMessage').value;

    try {
        const response = await fetch(`/api/tickets/${ticketId}/comments`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message })
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('commentMessage').value = '';
            viewTicket(ticketId);
            loadTickets();
            loadAllTickets();
        }
    } catch (error) {
        console.error('Error adding comment:', error);
    }
}

function closeTicketModal() {
    document.getElementById('ticketModal').classList.remove('active');
    document.getElementById('ticketAlert').innerHTML = '';
}

function closeViewModal() {
    document.getElementById('viewTicketModal').classList.remove('active');
}

function showAlert(elementId, message, type) {
    const alertClass = type === 'error' ? 'alert-error' : 'alert-success';
    document.getElementById(elementId).innerHTML = `
        <div class="alert ${alertClass}">${message}</div>
    `;
}