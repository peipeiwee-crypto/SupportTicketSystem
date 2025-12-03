<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketComment;
use App\Models\Ticket;
use App\Models\User;

class TicketCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = Ticket::all();
        $users = User::all();

        if ($tickets->isEmpty() || $users->isEmpty()) {
            $this->command->error('No tickets or users found! Please run UserSeeder and TicketSeeder first.');
            return;
        }

        // Get user IDs dynamically
        $user1 = $users->where('email', 'peipei.wee@bitzaro.com')->first()->id ?? $users[0]->id;
        $user2 = $users->where('email', 'john.doe@example.com')->first()->id ?? $users[1]->id;
        $user3 = $users->where('email', 'jane.smith@example.com')->first()->id ?? $users[2]->id;
        $user4 = $users->where('email', 'mike.johnson@example.com')->first()->id ?? $users[3]->id;
        $user5 = $users->where('email', 'sarah.williams@example.com')->first()->id ?? $users[4]->id;

        // Get ticket IDs (use the first 12 tickets or as many as available)
        $ticketIds = $tickets->pluck('id')->toArray();
        
        if (count($ticketIds) < 12) {
            $this->command->warn('Less than 12 tickets found. Some comments will be skipped.');
        }

        $comments = [
            // Comments for first ticket (Login page not working)
            [
                'ticket_id' => $ticketIds[0] ?? null,
                'user_id' => $user2,
                'message' => 'I am investigating this issue. It seems to be related to the authentication service.',
            ],
            [
                'ticket_id' => $ticketIds[0] ?? null,
                'user_id' => $user1,
                'message' => 'Thank you for looking into this. Please prioritize as it is affecting all users.',
            ],
            [
                'ticket_id' => $ticketIds[0] ?? null,
                'user_id' => $user3,
                'message' => 'I can confirm this issue. Tried multiple browsers with the same result.',
            ],

            // Comments for second ticket (Dashboard loading slowly)
            [
                'ticket_id' => $ticketIds[1] ?? null,
                'user_id' => $user4,
                'message' => 'Working on optimizing the database queries. Should be fixed by end of day.',
            ],
            [
                'ticket_id' => $ticketIds[1] ?? null,
                'user_id' => $user1,
                'message' => 'Great! Let me know if you need any additional information.',
            ],

            // Comments for third ticket (Export feature)
            [
                'ticket_id' => $ticketIds[2] ?? null,
                'user_id' => $user1,
                'message' => 'Can you provide more details? Which browser are you using?',
            ],
            [
                'ticket_id' => $ticketIds[2] ?? null,
                'user_id' => $user2,
                'message' => 'I am using Chrome version 120. Tried in Firefox as well, same issue.',
            ],

            // Comments for fourth ticket (Mobile app crashes)
            [
                'ticket_id' => $ticketIds[3] ?? null,
                'user_id' => $user5,
                'message' => 'This has been fixed in version 2.1.3. Please update your app.',
            ],
            [
                'ticket_id' => $ticketIds[3] ?? null,
                'user_id' => $user2,
                'message' => 'Confirmed! Updated and working perfectly now. Thank you!',
            ],

            // Comments for fifth ticket (Profile picture upload)
            [
                'ticket_id' => $ticketIds[4] ?? null,
                'user_id' => $user1,
                'message' => 'We have increased the upload limit to 5MB. Please try again.',
            ],

            // Comments for sixth ticket (Email notifications)
            [
                'ticket_id' => $ticketIds[5] ?? null,
                'user_id' => $user4,
                'message' => 'Checking the email queue configuration. Will update soon.',
            ],
            [
                'ticket_id' => $ticketIds[5] ?? null,
                'user_id' => $user3,
                'message' => 'This is urgent as users are missing important updates.',
            ],
            [
                'ticket_id' => $ticketIds[5] ?? null,
                'user_id' => $user4,
                'message' => 'Found the issue - SMTP settings were incorrect. Fixed now.',
            ],

            // Comments for seventh ticket (Search function)
            [
                'ticket_id' => $ticketIds[6] ?? null,
                'user_id' => $user2,
                'message' => 'Search algorithm has been improved. Closing this ticket.',
            ],

            // Comments for eighth ticket (User permissions)
            [
                'ticket_id' => $ticketIds[7] ?? null,
                'user_id' => $user3,
                'message' => 'This is a critical issue. Admin panel is completely broken.',
            ],
            [
                'ticket_id' => $ticketIds[7] ?? null,
                'user_id' => $user1,
                'message' => 'Assigned to development team. High priority.',
            ],

            // Comments for tenth ticket (API response time)
            [
                'ticket_id' => $ticketIds[9] ?? null,
                'user_id' => $user2,
                'message' => 'Added caching layer. Response time improved to under 500ms.',
            ],
            [
                'ticket_id' => $ticketIds[9] ?? null,
                'user_id' => $user5,
                'message' => 'Excellent work! Performance is much better now.',
            ],

            // Comments for eleventh ticket (Password reset link)
            [
                'ticket_id' => $ticketIds[10] ?? null,
                'user_id' => $user4,
                'message' => 'Extended expiration time to 60 minutes. Issue resolved.',
            ],

            // Comments for twelfth ticket (Comments not showing on mobile)
            [
                'ticket_id' => $ticketIds[11] ?? null,
                'user_id' => $user5,
                'message' => 'Can you specify which mobile browser and device you are using?',
            ],
            [
                'ticket_id' => $ticketIds[11] ?? null,
                'user_id' => $user2,
                'message' => 'Safari on iPhone 13 Pro, iOS 17. Also tested on Samsung Galaxy S22.',
            ],
        ];

        // Filter out comments with null ticket_id
        $comments = array_filter($comments, function($comment) {
            return $comment['ticket_id'] !== null;
        });

        foreach ($comments as $comment) {
            TicketComment::create($comment);
        }

        $commentCount = count($comments);
        $this->command->info("$commentCount comments created successfully!");
    }
}