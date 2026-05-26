<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProfileController extends Controller
{
    public function index() {

        $menu = [
            [
                'navigations' => [
                    ['name' => 'Dashboard', 'path' => '/dashboard'], 
                    ['name' => 'Projects', 'path' => '/projects'], 
                    ['name' => 'Collab', 'path' => '/collab'], 
                    ['name' => 'Profiles', 'path' => '/profile']
                ]
            ]
        ];

        $projects = Project::all();

        return view('profile.index', compact('menu', 'projects')); 
    }
}
