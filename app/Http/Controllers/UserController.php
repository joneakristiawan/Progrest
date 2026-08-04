<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $search = trim($request->q);

        if ($search === '') {
            return response()->json([]);
        }

        $users = User::query()
            ->where('id', '!=', Auth::id())
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            // Rank prefix matches first so results aren't dominated by low-id
            // (seeded) users when the limit is reached.
            ->orderByRaw('CASE WHEN name LIKE ? OR username LIKE ? OR email LIKE ? THEN 0 ELSE 1 END', ["{$search}%", "{$search}%", "{$search}%"])
            ->orderBy('name')
            ->limit(15)
            ->get([
                'id',
                'name',
                'username',
                'email',
                'avatar',
            ]);

        return response()->json($users);
    }


    public function searchProjectMembers(Request $request, Project $project)
    {
        $search = trim($request->q);

        if ($search === '') {
            return response()->json([]);
        }

        $users = $project->users()
            ->where('users.id', '!=', Auth::id())
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderByRaw('CASE WHEN name LIKE ? OR username LIKE ? OR email LIKE ? THEN 0 ELSE 1 END', ["{$search}%", "{$search}%", "{$search}%"])
            ->orderBy('name')
            ->limit(15)
            ->get([
                'users.id',
                'users.name',
                'users.username',
                'users.email',
                'users.avatar',
            ]);

        return response()->json($users);
    }
}