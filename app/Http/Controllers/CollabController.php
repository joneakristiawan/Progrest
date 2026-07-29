<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskCollaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollabController extends Controller{

    private function applyTaskSorting($query, string $sort, string $direction){
        switch ($sort) {
            case 'alphabetical':
                $query->orderBy('title', $direction);
                break;

            case 'deadline':
                $query->orderByRaw('deadline IS NULL')
                    ->orderBy('deadline', $direction);
                break;

            case 'points':
                $query->orderBy('go_collab_reward', $direction);
                break;

            case 'priority':
                $query->orderByRaw("
                    FIELD(priority, 'high', 'medium', 'low')
                ");
                break;

            default:
                $query->latest();
                break;
        }

        return $query;
    }

    public function index(Request $request){
        $menu = [
            [
                'navigations' => [
                    ['name'=>'Dashboard','path'=>'/dashboard'],
                    ['name'=>'Projects','path'=>'/projects'],
                    ['name'=>'Collab','path'=>'/collab'],
                    ['name'=>'Profiles','path'=>'/profile'],
                ]
            ]
        ];

        $user = Auth::user(); 
        $search = $request->input('search');
        $sort = $request->input('sort', 'deadline');
        $direction = $request->input('direction', 'asc');

        $searchFilter = function ($query) use ($search) {
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($project) use ($search) {
                        $project->where('title', 'like', "%{$search}%");
                    });
                });
            }
        };

        $activeCollabTasks = Task::with([
            'project.leader',
            'project.users',
            'users',
            'collaborations' => function ($query) {
                $query->where('user_id', auth()->id());
            },
        ])
        ->whereHas('collaborations', function ($query) {
            $query->where('user_id', auth()->id());
        })
        // ->whereNotIn('status', ['completed', 'cancelled'])
        ->tap($searchFilter)
        ->orderByRaw("FIELD(status,'in_progress','pending','completed', 'cancelled')")
        ->take(3)
        ->get();

        $activeCollabTasksCount = Task::whereHas('collaborations', function ($query) {
            $query->where('user_id', auth()->id());
        })
        // ->whereNotIn('status', ['completed', 'cancelled'])
        ->count();

        $allCollabTasks = Task::with([
            'project.leader',
            'project.users',
            'users',
        ])
        ->where('go_collab_enabled', true)
        ->where('status', 'in_progress')
        ->whereDoesntHave('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->whereDoesntHave('collaborators', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->whereDoesntHave('project.users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->whereHas('project', function ($query) use ($user) {
            $query->where('leader_id', '!=', $user->id);
        })
        ->tap($searchFilter);

        $this->applyTaskSorting($allCollabTasks, $sort, $direction);

        $allCollabTasks = $allCollabTasks
            ->paginate(9)
            ->withQueryString();

        // Statistics 

        $activeCollabsCount = Task::whereHas('collaborations', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereNotIn('status', ['completed', 'cancelled'])
        ->count();

        $completedCollabsCount = Task::whereHas('collaborations', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'completed')
        ->count();

        $pointsGained = TaskCollaboration::where('user_id', $user->id)
            ->sum('reward_earned');

        return view('collab.index', compact('menu', 'user', 'allCollabTasks', 'activeCollabTasks', 'activeCollabTasksCount', 'activeCollabsCount', 'completedCollabsCount', 'pointsGained'));
    }
    
    public function active(Request $request){
        $menu = [
            [
                'navigations' => [
                    ['name' => 'Dashboard', 'path' => '/dashboard'],
                    ['name' => 'Projects', 'path' => '/projects'],
                    ['name' => 'Collab', 'path' => '/collab'],
                    ['name' => 'Profiles', 'path' => '/profile'],
                ]
            ]
        ];

        $user = Auth::user();

        $search = $request->input('search');
        $sort = $request->input('sort', 'deadline');
        $direction = $request->input('direction', 'asc');

        $searchFilter = function ($query) use ($search) {
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('project', function ($project) use ($search) {
                            $project->where('title', 'like', "%{$search}%");
                        });
                });
            }
        };

        $activeCollabTasks = Task::with([
                'project.leader',
                'project.users',
                'users',
                'collaborations' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ])
            ->whereHas('collaborations', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            // ->whereNotIn('status', ['completed', 'cancelled'])
            ->tap($searchFilter); 
        
        $this->applyTaskSorting($activeCollabTasks, $sort, $direction);

        $activeCollabTasks = $activeCollabTasks
            ->paginate(9)
            ->withQueryString();

        return view('collab.active.index', compact(
            'menu',
            'activeCollabTasks'
        ));
    }

    public function join(Task $task){
        $user = auth()->user();

        abort_unless(
            $task->go_collab_enabled,
            403,
            'This task is not accepting collaborators.'
        );

        abort_if(
            $task->status === 'completed' || $task->status === 'cancelled',
            403,
            'This collaboration is no longer available.'
        );

        // Cannot join own project
        abort_if(
            $task->project->leader_id === $user->id,
            403,
            'Project leaders cannot join their own collaboration.'
        );

        // Internal assigned member
        abort_if(
            $task->users()->where('users.id', $user->id)->exists(),
            403,
            'Assigned members cannot join as collaborators.'
        );

        // Already collaborating
        abort_if(
            $task->collaborators()->where('users.id', $user->id)->exists(),
            422,
            'You have already joined this collaboration.'
        );

        // Collaboration limit
        abort_if(
            $task->collaborators()->count() >= $task->go_collab_limit,
            422,
            'This collaboration is already full.'
        );

        $task->collaborators()->attach($user->id, [
            'status' => 'in_progress',
            'reward_earned' => 0,
            'joined_at' => now(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function leave(Task $task){
        $user = auth()->user();

        $collaboration = TaskCollaboration::where([
            'task_id' => $task->id,
            'user_id' => $user->id,
        ])->first();

        abort_unless(
            $collaboration,
            404,
            'You are not collaborating on this task.'
        );

        abort_if(
            $task->status === 'pending',
            403,
            'A submission is currently under review.'
        );

        $collaboration->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}