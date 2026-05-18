@extends('layouts.projects-tasks') 

@section('title', 'Projects')

@section('content')
    @php
        $avatars = asset('images/profile.jpg')
    @endphp

    {{-- HEADER --}}

    <div class="bg-primary rounded-b-4xl px-8 py-6 flex flex-col lg:flex-row gap-4 justify-between shadow-md">
        <div>
            <h1 class="font-montserrat text-white text-4xl font-bold">Projects</h1>
            <h3 class="font-montserrat text-white/80 text-md mt-2">Which project will you progress on today?</h3>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-end items-center">

            {{-- Search Bar --}} 
            <form method="GET" class="relative">

                {{-- Simpan Hasil Sort Dulu --}}
                <input type="hidden"
                    name="sort"
                    value="{{ request('sort', 'recent') }}"
                >

                {{-- Simpan Hasil Direction Dulu --}}
                <input type="hidden"
                    name="direction"
                    value="{{ request('direction', 'desc') }}"
                >
                
                <div class="absolute pl-4 mt-2.5">
                    <x-lucide-search class="w-5 text-black"/>
                </div>

                <input type="text"
                    name="search"
                    value="{{ request('search') }}" 
                    placeholder="Search project..."
                    class="w-80 md:w-90 py-2 rounded-full text-md bg-white font-montserrat pl-12 focus:outline-none transition-all duration-300"
                    onchange="this.form.submit()"
                >
                    
            </form>

            {{-- CREATE PROJECT PANEL --}}
            <button onclick="openPanel()" class="bg-quartiary rounded-full px-6 py-2 h-fit flex items-center shadow-sm gap-2 hover:bg-quartiary-hover active:scale-95 text-sm md:text-base whitespace-nowrap">
                <span class="font-montserrat text-white text-md">Create Project</span>
                <div class="bg-primary rounded-full text-white p-0.5 flex items-center justify-center shrink-0">
                    <x-lucide-plus class="w-5 stroke-[2.5px]" />
                </div>
            </button>
        </div>
    </div>

    {{-- PROJECT STATISTICS --}}

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-8 py-6">

        {{-- Active Projects --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col lg:flex-row p-4 gap-3 items-center lg:items-start">
            <div class="w-10 h-10 rounded-3xl bg-pastel-green-background flex justify-center items-center">
                <x-lucide-folder-open class="w-5 text-pastel-green-text"/> 
            </div>
            <p class="text-text-primary text-4xl font-montserrat font-semibold">{{ count($projects) }}</p>
            <div class="flex flex-col text-sm items-center lg:items-start">
                <p class="text-text-primary font-montserrat font-semibold">Active Projects</p>
                <div class="flex gap-1 items-center mt-0.5">
                    <x-lucide-arrow-up class="text-pastel-green-text w-3" />
                    <p class="text-text-secondary font-montserrat text-[12px]">20% from last week</p>
                </div>
            </div>
        </div>
        
        {{-- Projects Completed --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col lg:flex-row p-4 gap-4 items-center lg:items-start">
            <div class="w-10 h-10 rounded-3xl bg-pastel-blue-background flex justify-center items-center">
                <x-lucide-folder-check class="w-5 text-pastel-blue-text"/> 
            </div>
            <p class="text-text-primary text-4xl font-montserrat font-semibold">5</p>
            <div class="flex flex-col text-sm items-center lg:items-start">
                <p class="text-text-primary font-montserrat font-semibold">Projects Done</p>
                <div class="flex gap-1 items-center mt-0.5">
                    <x-lucide-arrow-up class="text-pastel-green-text w-3" />
                    <p class="text-text-secondary font-montserrat text-[12px]">100% from last week</p>
                </div>
            </div>
        </div>

        {{-- Projects Led --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col lg:flex-row p-4 gap-4 items-center lg:items-start">
            <div class="w-10 h-10 rounded-3xl bg-pastel-yellow-background flex justify-center items-center">
                <x-lucide-user-star class="w-5 text-pastel-yellow-text"/> 
            </div>
            <p class="text-text-primary text-4xl font-montserrat font-semibold">5</p>
            <div class="flex flex-col text-sm items-center lg:items-start">
                <p class="text-text-primary font-montserrat font-semibold">Projects Led</p>
                <div class="flex gap-1 items-center mt-0.5">
                    <x-lucide-arrow-up class="text-pastel-green-text w-3" />
                    <p class="text-text-secondary font-montserrat text-[12px]">10% from last week</p>
                </div>
            </div>
        </div>

        {{-- Team Members --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col lg:flex-row p-4 gap-4 items-center lg:items-start">
            <div class="w-10 h-10 rounded-3xl bg-pastel-purple-background flex justify-center items-center">
                <x-lucide-users class="w-5 text-pastel-purple-text"/> 
            </div>
            <p class="text-text-primary text-4xl font-montserrat font-semibold">5</p>
            <div class="flex flex-col text-sm items-center lg:items-start">
                <p class="text-text-primary font-montserrat font-semibold">Team Members</p>
                <div class="flex gap-1 items-center mt-0.5">
                    <x-lucide-arrow-up class="text-pastel-green-text w-3" />
                    <p class="text-text-secondary font-montserrat text-[12px]">20% from last week</p>
                </div>
            </div>
        </div>
    </div>

    {{-- PROJECTS LIST --}}

    <div class="px-8">
        <div class="flex justify-between items-center">
            <h1 class="font-montserrat text-text-primary text-2xl font-bold">All Projects</h1>
            
            <div class="flex gap-4">

                {{-- SORT BUTTON --}}

                <form method="GET" class="flex gap-3">

                    {{-- Direction Toggle --}}
                    <button
                        type="submit"
                        name="direction"
                        value="{{ request('direction') === 'asc' ? 'desc' : 'asc' }}"
                        class="bg-background rounded-2xl p-2 shadow-sm hover:bg-surface transition-colors"
                    >
                        <x-lucide-arrow-up-down class="w-5 h-5 text-text-primary" />
                    </button>

                    {{-- Keep current sort --}}
                    <input type="hidden"
                        name="sort"
                        value="{{ request('sort', 'recent') }}">

                    {{-- Sort Dropdown --}}
                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="bg-background rounded-3xl px-3 shadow-sm font-montserrat text-sm text-text-primary hover:bg-surface transition-colors focus:outline-none"
                    >
                        <option value="recent" class="outline-none"
                            {{ request('sort') === 'recent' ? 'selected' : '' }}>
                            Recently Updated
                        </option>

                        <option value="alphabetical"
                            {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>
                            Alphabetical
                        </option>

                        <option value="progress"
                            {{ request('sort') === 'progress' ? 'selected' : '' }}>
                            Progress
                        </option>
                    </select>

                </form>
            </div>
        </div>

        <div class="mt-4 grid  grid-cols-1 md:grid-cols-2 gap-6 lg:grid-cols-3">
            @foreach ($projects as $project)
                @include('projects.card', [
                    'title' => $project->title,
                    'description' => $project->description,
                    'progress' => $project->progress,
                    'collaborators' => $project->members,
                    'accentColor' => $project->accent, 
                    'icon' => $project->icon, 
                    'days_remaining' => $project->days_remaining
                ])
            @endforeach
        </div>
    </div>
@endsection 