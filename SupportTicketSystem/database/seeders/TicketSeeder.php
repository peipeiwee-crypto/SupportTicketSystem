<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 5) {
            $this->command->error('Need at least 5 users! Please run UserSeeder first.');
            return;
        }

        // Get actual user IDs
        $user1 = $users->where('email', 'peipei.wee@bitzaro.com')->first()->id ?? $users[0]->id;
        $user2 = $users->where('email', 'john.doe@example.com')->first()->id ?? $users[1]->id;
        $user3 = $users->where('email', 'jane.smith@example.com')->first()->id ?? $users[2]->id;
        $user4 = $users->where('email', 'mike.johnson@example.com')->first()->id ?? $users[3]->id;
        $user5 = $users->where('email', 'sarah.williams@example.com')->first()->id ?? $users[4]->id;

        $tickets = [
            [
                'title' => 'Login page not working',
                'description' => 'Users are unable to login with correct credentials. The error message shows "Invalid credentials" even when the password is correct.',
                'status' => 'open',
                'priority' => 'high',
                'created_by' => $user1,
            ],
            [
                'title' => 'Dashboard loading slowly',
                'description' => 'The main dashboard takes more than 10 seconds to load. This happens consistently for all users.',
                'status' => 'in_progress',
                'priority' => 'medium',
                'created_by' => $user1,
            ],
            [
                'title' => 'Export feature not downloading CSV',
                'description' => 'When clicking the export button, nothing happens. Expected behavior is to download a CSV file with the data.',
                'status' => 'open',
                'priority' => 'low',
                'created_by' => $user2,
            ],
            [
                'title' => 'Mobile app crashes on Android 12',
                'description' => 'The mobile application crashes immediately after opening on Android 12 devices. Works fine on Android 11 and below.',
                'status' => 'resolved',
                'priority' => 'high',
                'created_by' => $user2,
            ],
            [
                'title' => 'Profile picture upload failing',
                'description' => 'Users cannot upload profile pictures larger than 2MB. Getting error: "File too large".',
                'status' => 'open',
                'priority' => 'medium',
                'created_by' => $user3,
            ],
            [
                'title' => 'Email notifications not being sent',
                'description' => 'Users are not receiving email notifications for ticket updates. Checked spam folder as well.',
                'status' => 'in_progress',
                'priority' => 'high',
                'created_by' => $user3,
            ],
            [
                'title' => 'Search function returns incorrect results',
                'description' => 'When searching for tickets by keyword, the results include unrelated tickets.',
                'status' => 'closed',
                'priority' => 'low',
                'created_by' => $user4,
            ],
            [
                'title' => 'User permissions not being applied',
                'description' => 'Admin users are seeing the same restricted view as regular users.',
                'status' => 'open',
                'priority' => 'high',
                'created_by' => $user4,
            ],
            [
                'title' => 'Dark mode theme issues',
                'description' => 'Text is not visible in dark mode on several pages. Need to fix contrast issues.',
                'status' => 'open',
                'priority' => 'low',
                'created_by' => $user5,
            ],
            [
                'title' => 'API response time too slow',
                'description' => 'API endpoints are taking 3-5 seconds to respond. Should be under 1 second.',
                'status' => 'in_progress',
                'priority' => 'medium',
                'created_by' => $user5,
            ],
            [
                'title' => 'Password reset link expired',
                'description' => 'Password reset links are expiring after 10 minutes. Users need more time.',
                'status' => 'resolved',
                'priority' => 'medium',
                'created_by' => $user1,
            ],
            [
                'title' => 'Comments not showing on mobile',
                'description' => 'Ticket comments are not displayed when viewing on mobile browsers.',
                'status' => 'open',
                'priority' => 'high',
                'created_by' => $user2,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }

        $this->command->info('12 tickets created successfully!');
    }
}