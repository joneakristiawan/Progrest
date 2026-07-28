<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskCollaboration;
use App\Models\TaskSubmission;
use App\Notifications\ActivityNotification;
use Illuminate\Http\Request;

class TaskSubmissionController extends Controller{

    public function submit(Request $request, Task $task){
        $user = auth()->user();
        
        $isAssigned = $task->users()
            ->where('users.id', $user->id)
            ->exists();
        
        $isCollaborator = $task->collaborators()
            ->where('users.id', $user->id)
            ->exists();

        $isLeader = $task->project->leader_id === $user->id;

        abort_unless(
            $isAssigned || $isCollaborator || $isLeader,
            403,
            'You are not allowed to submit this task.'
        );

        if ($task->activeSubmission 
            && $task->activeSubmission->status === 'pending') {
            return response()->json([
                'message' => 'A submission already exists for this task.'
            ], 422);
        }

        $validated = $request->validate([
            'proof_image' => [
                'nullable',
                'image',
                'max:4096',
            ],
            'proof_link' => [
                'nullable',
                'url',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        if (
            empty($validated['proof_image']) &&
            empty($validated['proof_link'])
        ) {
            return response()->json([
                'message' => 'Please provide either a proof image or a proof link.'
            ], 422);
        }

        // Store proof image

        $proofImage = null;

        if ($request->hasFile('proof_image')) {
            $proofImage = $request
                ->file('proof_image')
                ->store('task-submissions', 'public');
        }

        // Create submission

        $submission = TaskSubmission::create([
            'task_id' => $task->id,
            'submitted_by' => $user->id,

            'proof_image' => $proofImage,
            'proof_link' => $validated['proof_link'] ?? null,
            'notes' => $validated['notes'] ?? null,

            'status' => 'pending',
        ]);

        $task->update([
            'status' => 'pending',
        ]);

        // Notify project leader

        if ($task->project->leader_id !== $user->id) {

            $task->project->leader->notify(
                new ActivityNotification(
                    title: 'Task Submission',
                    message: $user->name .
                        ' submitted "' .
                        $task->title .
                        '" for review.',
                    type: 'task_submission',
                    projectId: $task->project_id,
                    taskId: $task->id,
                )
            );
        }

        return response()->json([
            'success' => true,
            'submission' => $submission,
        ]);
    }

    public function approve(TaskSubmission $submission){
        $user = auth()->user();
        $task = $submission->task; 

        $isLeader = $task->project->leader_id === $user->id;
        
        abort_unless(
            $isLeader,
            403,
            'Only project leaders can review task submissions.'
        );

        $submission->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Handle Point Reward

        $reward = $task->go_collab_reward ?? 0;

        if ($task->go_collab_enabled) {
        
            $leader = $task->project->leader;
            $reward = (int) ($task->go_collab_reward ?? 0);
        
            if ($leader->points < $reward) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project Leader does not have enough credits.'
                ], 422);
            }
        
            $leader->decrement('points', $reward);
            $submission->submitter->increment('points', $reward);
        }

        $submission->task->update([
            'status' => 'completed',
            'is_completed' => true,
        ]);

        if ($task->go_collab_enabled) {
            TaskCollaboration::where('task_id', $task->id)
                ->where('user_id', $submission->submitted_by)
                ->update([
                    'status' => 'completed',
                ]);
        }

        $project = $task->project;

        $hasIncompleteTasks = $project->tasks()
            ->where('status', '!=', 'completed')
            ->exists();

        if (! $hasIncompleteTasks) {
            $project->update([
                'status' => 'completed',
            ]);
        }

        foreach ($project->users as $member) {
            if ($member->id === auth()->id()) {
                continue;
            }
            $member->notify(
                new ActivityNotification(
                    title: 'Task Completed',
                    message: '"'.$task->title.'" has been completed.',
                    type: 'task_completed',
                    projectId: $project->id,
                    taskId: $task->id,
                )
            );
        }

        $submission->submitter->notify(
            new ActivityNotification(
                title: 'Submission Approved',
                message: 'Your submission for "'.$task->title.'" was approved.',
                type: 'task_completed',
                projectId: $project->id,
                taskId: $task->id,
            )
        );

        return response()->json([
            'success' => true,
        ]);
    }

    public function reject(TaskSubmission $submission){
        $user = auth()->user();
        $task = $submission->task; 
        
        $isLeader = $task->project->leader_id === $user->id;
        
        abort_unless(
            $isLeader,
            403,
            'Only project leaders can review task submissions.'
        );

        $submission->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $submission->task->update([
            'status' => 'in_progress',
        ]);

        // Jaga-jaga kalo proof image masih muncul/ketinggalan 
        if ($submission->proof_image) {
            \Storage::disk('public')->delete($submission->proof_image);
        }

        $project = $task->project; 

        foreach ($project->users as $member) {
            if ($member->id === auth()->id()) {
                continue;
            }
            $member->notify(
                new ActivityNotification(
                    title: 'Task Rejected',
                    message: '"'.$task->title.'" has been rejected for completion.',
                    type: 'task_rejected',
                    projectId: $project->id,
                    taskId: $task->id,
                )
            );
        }

        $submission->submitter->notify(
            new ActivityNotification(
                title: 'Submission Rejected',
                message: 'Your submission for "'.$task->title.'" was rejected.',
                type: 'task_rejected',
                projectId: $project->id,
                taskId: $task->id,
            )
        );

        $submission->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
