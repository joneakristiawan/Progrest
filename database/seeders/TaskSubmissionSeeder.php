<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TaskSubmission;

class TaskSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        // Completed tasks: create approved submissions
        Task::where('status', 'completed')
            ->each(function ($task) {

                $user = $task->users->first();

                if (!$user) {
                    return;
                }

                TaskSubmission::create([
                    'task_id' => $task->id,
                    'submitted_by' => $user->id,

                    'proof_image' => null,
                    'proof_link' => 'https://example.com/completed-proof',
                    'notes' => 'Task completed and approved.',

                    'status' => 'approved',
                    'submitted_at'  => now(),
                ]);
            });


        // Pending tasks: create submissions waiting for review
        Task::where('status', 'pending')
            ->each(function ($task) {

                $user = $task->users->first();

                if (!$user) {
                    return;
                }

                TaskSubmission::create([
                    'task_id' => $task->id,
                    'submitted_by' => $user->id,

                    'proof_image' => null,
                    'proof_link' => 'https://example.com/pending-proof',
                    'notes' => 'Submitted work awaiting project leader review.',

                    'status' => 'pending',
                    'submitted_at'  => now(),
                ]);
            });
    }
}