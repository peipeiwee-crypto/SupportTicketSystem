<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the user's tickets.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Ticket::with(['creator', 'comments'])
            ->where('created_by', auth()->id());

        // Apply filters
        $query->byStatus($request->status)
              ->byPriority($request->priority)
              ->search($request->search);

        // Get paginated results
        $tickets = $query->latest()->paginate(9);

        return response()->json([
            'success' => true,
            'data' => $tickets,
        ], 200);
    }

    /**
     * Display all tickets (for browsing and commenting).
     */
    public function all(Request $request): JsonResponse
    {
        $query = Ticket::with(['creator', 'comments']);

        // Apply filters
        $query->byStatus($request->status)
              ->byPriority($request->priority)
              ->search($request->search);

        // Get paginated results
        $tickets = $query->latest()->paginate(9);

        return response()->json([
            'success' => true,
            'data' => $tickets,
        ], 200);
    }

    /**
     * Store a newly created ticket.
     */
    public function store(StoreTicketRequest $request): JsonResponse
    {
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium',
            'status' => 'open',
            'created_by' => auth()->id(),
        ]);

        $ticket->load(['creator', 'comments']);

        return response()->json([
            'success' => true,
            'data' => $ticket,
            'message' => 'Ticket created successfully',
        ], 201);
    }

    /**
     * Display the specified ticket.
     * Any authenticated user can view any ticket.
     */
    public function show(Ticket $ticket): JsonResponse
    {
        $ticket->load(['creator', 'comments.user']);

        return response()->json([
            'success' => true,
            'data' => $ticket,
        ], 200);
    }

    /**
     * Update the specified ticket.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $ticket->update($request->validated());
        $ticket->load(['creator', 'comments']);

        return response()->json([
            'success' => true,
            'data' => $ticket,
            'message' => 'Ticket updated successfully',
        ], 200);
    }

    /**
     * Remove the specified ticket (soft delete).
     */
    public function destroy(Ticket $ticket): JsonResponse
    {
        // Check authorization
        if ($ticket->created_by !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this ticket.',
            ], 403);
        }

        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully',
        ], 200);
    }
}