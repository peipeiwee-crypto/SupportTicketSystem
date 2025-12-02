<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Ticket;
use App\Models\TicketComment;

class TicketCommentController extends Controller
{
    public function store(StoreCommentRequest $request, Ticket $ticket)
    {
        $comment = TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'data' => $comment,
        ], 201);
    }
}


