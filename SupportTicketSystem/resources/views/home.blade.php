@extends('layouts.app')

@section('title', 'Home - Support Ticket System')

@section('content')
<div class="main-content">
    <!-- Login Section -->
    <div id="loginSection" class="section">
        <h2>Login</h2>
        <div id="loginAlert"></div>
        <form onsubmit="login(event)">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="loginEmail" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="loginPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- Register Section -->
    <div id="registerSection" class="section">
        <h2>Register</h2>
        <div id="registerAlert"></div>
        <form onsubmit="register(event)">
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="registerName" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="registerEmail" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="registerPassword" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" id="registerPasswordConfirm" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
        </form>
    </div>

    <!-- Tickets Section -->
    <div id="ticketsSection" class="section">
        <!-- Tab Navigation -->
        <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
            <button class="tab-btn active" onclick="switchTab('myTickets')">My Tickets</button>
            <button class="tab-btn" onclick="switchTab('allTickets')">All Tickets</button>
        </div>

        <!-- My Tickets Tab -->
        <div id="myTicketsTab" class="tab-content active">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>My Tickets</h2>
                <button class="btn btn-primary" onclick="showCreateTicket()">Create New Ticket</button>
            </div>

            <!-- Filters -->
            <div class="filters">
                <input type="text" id="searchInput" placeholder="Search tickets..." oninput="loadTickets()">
                <select id="statusFilter" onchange="loadTickets()">
                    <option value="">All Status</option>
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
                <select id="priorityFilter" onchange="loadTickets()">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div id="ticketsContainer"></div>
        </div>

        <!-- All Tickets Tab -->
        <div id="allTicketsTab" class="tab-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>All Tickets</h2>
                <p style="color: #666; font-size: 0.9rem;">Browse and comment on all tickets</p>
            </div>

            <!-- Filters -->
            <div class="filters">
                <input type="text" id="searchAllInput" placeholder="Search tickets..." oninput="loadAllTickets()">
                <select id="statusAllFilter" onchange="loadAllTickets()">
                    <option value="">All Status</option>
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
                <select id="priorityAllFilter" onchange="loadAllTickets()">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div id="allTicketsContainer"></div>
        </div>
    </div>
</div>

@include('partials.modals')
@endsection