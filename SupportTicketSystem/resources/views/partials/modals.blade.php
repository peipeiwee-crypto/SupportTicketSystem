<!-- Create/Edit Ticket Modal -->
<div id="ticketModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="ticketModalTitle">Create Ticket</h2>
            <button class="close-btn" onclick="closeTicketModal()">&times;</button>
        </div>
        <div id="ticketAlert"></div>
        <form id="ticketForm" onsubmit="saveTicket(event)">
            <input type="hidden" id="ticketId">
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="ticketTitle" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea id="ticketDescription" required></textarea>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select id="ticketPriority">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="form-group" id="statusGroup" style="display:none;">
                <label>Status</label>
                <select id="ticketStatus">
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" onclick="closeTicketModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- View Ticket Modal -->
<div id="viewTicketModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ticket Details</h2>
            <button class="close-btn" onclick="closeViewModal()">&times;</button>
        </div>
        <div id="viewTicketContent"></div>
    </div>
</div>