@extends('layouts.task') 

@section('title', 'Project - ' . $project->title)

@section('content')

    {{-- PROJECT HEADER --}}
    <div 
        x-data="projectModal(@js($project))"
        class="bg-primary rounded-b-[2.5rem] shadow-lg overflow-hidden">
        <div class="px-7 py-8">

            {{-- Bagian atas --}}
            <div class="flex flex-col lg:flex-row justify-center items-center gap-8">

                {{-- Kiri --}}
                <div class="flex gap-6 flex-1">

                    {{-- Project Icon --}}
                    <div class="w-12 h-12 rounded-2xl bg-white/20 border border-white/10 flex items-center justify-center shrink-0">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center">

                            <x-dynamic-component
                                :component="'lucide-' . $project->icon"
                                class="w-8 h-8 text-white"
                            />
                        </div>
                    </div>

                    {{-- Project Info --}}
                    <div class="flex flex-col justify-center">
                        <h1 class="font-montserrat text-3xl font-bold text-white leading-none">
                            {{ $project->title }}
                        </h1>
                        <p class="mt-2 max-w-xl text-white/70 font-montserrat text-md leading-relaxed">
                            {{ $project->description }}
                        </p>
                    </div>
                </div>

                {{-- Bagian kanan --}}
                <div class="flex flex-col sm:flex-row gap-4 items-start">

                    {{-- Search --}}
                    <form method="GET" class="relative">
                        <input
                            type="hidden"
                            name="sort"
                            value="{{ request('sort','recent') }}"
                        >
                        <input
                            type="hidden"
                            name="direction"
                            value="{{ request('direction','desc') }}"
                        >
                        <div class="absolute inset-y-0 left-2.5 flex items-center pointer-events-none z-10">
                            <x-lucide-search class="w-5 h-5 text-white"/>
                        </div>
                        <input
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('main.ph.search-task') }}"
                            onchange="this.form.submit()"
                            class="w-70
                                text-sm
                                rounded-xl
                                bg-white/10
                                border border-white/10
                                backdrop-blur-md
                                text-white
                                placeholder:text-white/60
                                py-2.5
                                pl-10
                                pr-2
                                outline-none
                                font-montserrat"
                        >
                    </form>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3"
                    >
                        {{-- Create Task --}}
                        <button
                            onclick="openPanel()"
                            @click="showCreateModal = true"
                            class="flex items-center gap-3
                                bg-quartiary
                                hover:bg-quartiary-hover
                                rounded-2xl
                                px-3.5
                                py-2.5
                                text-white
                                font-semibold
                                font-montserrat text-sm
                                cursor-pointer
                                transition">

                            <div
                                class="w-6 h-6 rounded-full
                                    bg-primary
                                    flex items-center justify-center">

                                <x-lucide-plus class="w-5"/>
                            </div>

                            {{ __('main.task.create') }}
                        </button>

                        {{-- Project Menu --}}
                        <div class="relative">

                            <button
                                @click="menuOpen = !menuOpen"
                                class="w-11 h-11
                                    rounded-2xl
                                    bg-white/10
                                    hover:bg-white/15
                                    border border-white/10
                                    backdrop-blur-md
                                    flex items-center justify-center cursor-pointer
                                    transition">

                                <x-lucide-ellipsis class="w-5 h-5 text-white"/>
                            </button>

                            {{-- Dropdown --}}
                            <div
                                x-show="menuOpen"
                                @click.outside="menuOpen = false"
                                x-transition
                                x-cloak
                                class="absolute right-0 mt-2
                                    w-44
                                    rounded-2xl
                                    bg-surface
                                    border border-white/10
                                    shadow-xl
                                    overflow-hidden
                                    z-50">

                                {{-- Edit --}}
                                <button
                                    @click="openEdit()"
                                    class="w-full flex items-center gap-3
                                        px-4 py-3
                                        text-sm
                                        font-montserrat
                                        text-text-primary cursor-pointer
                                        hover:bg-white/5">

                                    <x-lucide-pencil class="w-4 h-4"/>
                                    {{ __('main.task.edit-project') }}
                                </button>

                                {{-- Delete --}}
                                <button
                                    @click="openDelete()"
                                    class="w-full flex items-center gap-3
                                        px-4 py-3
                                        text-sm
                                        font-montserrat cursor-pointer
                                        text-red-400
                                        hover:bg-red-500/10">

                                    <x-lucide-trash-2 class="w-4 h-4"/>
                                    {{ __('main.task.delete-project') }}
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-white/20 mt-4 pt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 justify-items-center">

                    {{-- Project LEader --}}
                    <div class="relative">
                        <p class="text-white/80 uppercase tracking-wider font-montserrat text-xs">
                            {{ __('main.task.project-leader') }}
                        </p>
                        <div class="flex items-center mt-4">
                            <div
                                class="w-12 h-12 rounded-full
                                    bg-yellow-400/20
                                    flex items-center justify-center
                                    mr-4 absolute">
                                <x-lucide-crown
                                    class="w-6 text-yellow-300"/>
                            </div>

                            <img
                                src="{{ $project->leader->avatar ? $project->leader->avatar : '/images/profile.jpg' }}"
                                class="ml-9 w-10 h-10 rounded-full object-cover border-2 border-white"
                            >

                            <div class="ml-4">
                                <h4 class="text-white font-semibold">
                                    {{ $project->leader->name }}
                                </h4>
                                <span class="text-white/60 text-sm">
                                    {{ __('main.task.project-leader') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- MEMBERS --}}
                    <div>
                        <p class="text-white/80 uppercase tracking-wider text-xs font-montserrat">
                            {{ __('main.task.members') }}
                        </p>
                        <div class="flex items-center mt-4">
                            <div class="flex -space-x-4">
                                @foreach(array_slice($teamMembers,0,$displayLimit) as $avatar)
                                    <img
                                        src="{{ $avatar }}"
                                        class="w-10 h-10 rounded-full border-2 border-primary object-cover">
                                @endforeach

                                @if($extraMembers > 0)
                                    <div
                                        class="w-10 h-10 rounded-full bg-white
                                            flex items-center justify-center
                                            font-bold">
                                        +{{ $extraMembers }}
                                    </div>
                                @endif
                            </div>

                            <span class="ml-4 text-white/50 text-sm">
                                {{ count($teamMembers) }} {{ __('main.task.members') }}
                            </span>
                        </div>
                    </div>

                    {{-- PROGRESS --}}
                    <div>
                        <p class="text-white/80 uppercase tracking-wider text-xs font-montserrat">
                            {{ __('main.task.progress') }}
                        </p>
                        <div class="flex items-center mt-4">

                            {{-- Circular progress indicator completed tasks --}}
                            <div
                                class="w-14 h-14 rounded-full flex items-center justify-center"
                                style="
                                    background:
                                    conic-gradient(
                                        #4ADE80 {{ $progress }}%,
                                        rgba(255,255,255,.2) 0
                                    );
                                "
                            >
                                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                                    <span class="text-xs text-white">
                                        {{ round($progress) }}%
                                    </span>
                                </div>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-white text-2xl font-bold font-montserrat">
                                    {{ $completedTasks }}
                                    /
                                    {{ $totalTasks }}
                                </h4>
                                <p class="text-white/60 text-sm">
                                    {{ __('main.task.tasks-completed') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- DEADLINE --}}
                    <div>
                        <p class="text-white/80 uppercase tracking-wider text-xs font-montserrat">
                            {{ __('main.task.due-date') }}
                        </p>
                        <div class="flex items-center mt-4">
                            <div
                                class="w-10 h-10 rounded-xl
                                    bg-white/10
                                    flex items-center justify-center">

                                <x-lucide-calendar
                                    class="w-5 text-green-300"/>
                            </div>
                            <div class="ml-4">
                                @if (!is_null($project->deadline))
                                    <h4 class="text-white text-lg font-semibold font-montserrat">
                                        {{ $project->deadline->format('d M Y') }}
                                    </h4>
                                @else
                                    <h4 class="text-white text-lg font-semibold font-montserrat">
                                        {{ __('main.task.deadline-not-set') }}
                                    </h4>
                                @endif
                                @if (!is_null($project->deadline))
                                    @if ($project->days_remaining < 0)
                                        <p class="text-red-accent font-semibold font-montserrat text-sm">
                                            {{ trans_choice('main.task.days-overdue', $project->days_remaining * -1, ['count' => $project->days_remaining * -1]) }}
                                        </p>
                                    @elseif ($project->days_remaining > 0)
                                        <p class="text-white/80 font-montserrat text-sm">
                                            {{ trans_choice('main.task.days-remaining', $project->days_remaining, ['count' => $project->days_remaining]) }}
                                        </p>
                                    @else
                                        <p class="text-yellow-300 font-montserrat text-sm">
                                            {{ __('main.task.due-today') }}
                                        </p>
                                    @endif
                                @else
                                    <p class="text-white/80 font-montserrat text-sm">
                                        {{ $project->days_remaining }}
                                        ---
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- EDIT PROJECT MODAL --}}
        <div
            x-show="showEdit"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 shadow-2xl backdrop-blur-sm p-6"
        >

            {{-- Green Accent --}}
            <div
                class="absolute -top-24 left-3/4
                    h-64 w-86 -translate-x-1/2
                    rounded-full
                    bg-emerald-300/15
                    blur-3xl"
            ></div>

            <div
                @click.outside="closeAll()"
                class="bg-background rounded-3xl shadow-xl
                    w-full max-w-2xl
                    max-h-[90vh]
                    flex flex-col
                    overflow-hidden"
            >

                {{-- HEADER --}}
                <div
                    class="flex items-center justify-between
                        px-6 py-5
                        border-b-2 border-border
                        shrink-0"
                >

                    <div class="flex items-center gap-3 font-montserrat">

                        <div
                            class="flex justify-center items-center
                                w-10 h-10
                                rounded-2xl
                                border-2
                                border-pastel-green-text
                                bg-pastel-green-background
                                shadow-[0_10px_30px_rgba(0,0,0,0.12)]"
                        >

                            <x-lucide-folder-open
                                class="w-6 h-6 text-pastel-green-text"
                            />
                        </div>

                        <div>
                            <h1
                                class="font-montserrat
                                    text-2xl
                                    font-bold
                                    text-text-primary"
                            >
                                Edit Project
                            </h1>
                            <p
                                class="text-sm
                                    text-text-secondary"
                            >
                                Update project information
                            </p>
                        </div>
                    </div>

                    <button
                        @click="closeAll()"
                        class="w-12 h-12
                            rounded-full
                            hover:bg-surface
                            flex items-center justify-center
                            hover:rotate-90
                            transition
                            duration-300
                            z-101
                            cursor-pointer"
                    >
                        <x-lucide-x
                            class="w-5 h-5 text-text-primary"
                        />
                    </button>
                </div>

                {{-- BODY --}}
                <div
                    class="flex-1 overflow-y-auto
                        px-6 py-5
                        space-y-5"
                >
                    {{-- PROJECT TITLE --}}
                    <div>
                        <p
                            class="font-montserrat
                                font-semibold
                                text-[12px]
                                text-text-primary"
                        >
                            Project Title
                        </p>

                        <div
                            class="bg-surface
                                rounded-2xl
                                px-5 py-3
                                mt-1"
                        >
                            <input
                                type="text"
                                x-model="form.title"
                                placeholder="Enter project title..."
                                class="w-full
                                    bg-transparent
                                    outline-none
                                    text-sm
                                    font-montserrat
                                    text-text-primary
                                    placeholder:text-text-secondary"
                            >
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div>
                        <p
                            class="font-montserrat
                                font-semibold
                                text-[12px]
                                text-text-primary"
                        >
                            Description
                        </p>
                        <div
                            class="bg-surface
                                rounded-2xl
                                px-5 py-3
                                mt-1"
                        >

                            <textarea
                                x-model="form.description"
                                rows="3"
                                class="w-full
                                    bg-transparent
                                    resize-none
                                    overflow-hidden
                                    outline-none
                                    text-sm
                                    leading-7
                                    font-montserrat
                                    text-black
                                    placeholder:text-text-secondary"
                            ></textarea>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div
                        class="border-t-2
                            border-border"
                    ></div>

                    {{-- APPEARANCE --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- PROJECT THEME --}}
                        <div
                            class="space-y-4
                                p-5
                                rounded-2xl
                                bg-surface"
                        >

                            <div class="flex items-center gap-2">
                                <div class="shadow-lg shadow-pastel-green-background">
                                    <x-lucide-palette
                                        class="w-5 text-pastel-green-text"
                                    />
                                </div>
                                <p
                                    class="font-montserrat
                                        font-semibold
                                        text-sm
                                        text-text-primary"
                                >
                                    Project Theme
                                </p>
                            </div>

                            <div
                                class="grid
                                    grid-cols-3
                                    sm:grid-cols-4
                                    gap-4
                                    justify-items-center"
                            >

                                @php
                                    $themes = [
                                        ['#0EA5A4','bg-cyan','ring-cyan/20'],
                                        ['#8B5A2B','bg-brown','ring-brown/20'],
                                        ['#7C2D8E','bg-purple','ring-purple/20'],
                                        ['#0056D2','bg-blue','ring-blue/20'],
                                        ['#F35C75','bg-pink','ring-pink/20'],
                                        ['#1F5D3A','bg-green','ring-green/20'],
                                        ['#F38D08','bg-orange','ring-orange/20'],
                                        ['#FFEB99','bg-yellow','ring-yellow/20'],
                                        ['#000000','bg-black','ring-black/20'],
                                        ['#0F766E','bg-teal','ring-teal/20'],
                                        ['#84CC16','bg-lime','ring-lime/20'],
                                        ['#E11D48','bg-rose','ring-rose/20'],
                                    ];
                                @endphp

                                @foreach($themes as [$value,$bg,$ring])
                                    <button
                                        type="button"
                                        @click="form.accent='{{ $value }}'"

                                        :class="form.accent==='{{ $value }}'
                                            ? 'ring-4 ring-offset-2 {{ $ring }}'
                                            : ''"
                                        class="w-9 h-9
                                            rounded-full
                                            {{ $bg }}
                                            flex items-center justify-center
                                            transition-all
                                            cursor-pointer"
                                    >
                                        <x-lucide-check
                                            x-show="form.accent==='{{ $value }}'"
                                            class="w-4 text-text-contrast"
                                        />
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- PROJECT ICON --}}
                        <div
                            class="space-y-4
                                p-5
                                rounded-2xl
                                bg-surface"
                        >

                            <div class="flex items-center gap-2">
                                <div class="shadow-lg shadow-pastel-green-background">
                                    <x-lucide-loader-pinwheel
                                        class="w-5 text-pastel-green-text"
                                    />
                                </div>
                                <p
                                    class="font-montserrat
                                        font-semibold
                                        text-sm
                                        text-text-primary"
                                >
                                    Project Icon
                                </p>
                            </div>

                            @php
                                $icons = [
                                    'folder',
                                    'clock',
                                    'book-open',
                                    'chart-column',
                                    'trees',
                                    'calendar',
                                    'backpack',
                                    'camera',
                                    'shopping-cart',
                                    'gamepad-2',
                                    'cat',
                                    'cooking-pot',
                                ];
                            @endphp

                            <div
                                class="grid
                                    grid-cols-3
                                    sm:grid-cols-4
                                    gap-4
                                    justify-items-center"
                            >
                                @foreach($icons as $icon)
                                    <button
                                        type="button"
                                        @click="form.icon='{{ $icon }}'"
                                        :class="form.icon==='{{ $icon }}'
                                            ? 'bg-quartiary text-white'
                                            : 'bg-background text-text-secondary'"
                                        class="w-11 h-11
                                            rounded-xl
                                            border border-border
                                            hover:bg-secondary
                                            transition
                                            flex items-center justify-center
                                            cursor-pointer"
                                    >
                                        <x-dynamic-component
                                            :component="'lucide-'.$icon"
                                            class="w-5 h-5"
                                        />
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- DEADLINE --}}
                    <div>
                        <p
                            class="font-montserrat
                                font-semibold
                                text-[12px]
                                text-text-primary"
                        >
                            Project Deadline
                        </p>

                        <div class="relative mt-1">
                            <x-lucide-calendar
                                class="absolute
                                    right-4
                                    top-1/2
                                    -translate-y-1/2
                                    w-4 h-4
                                    text-text-secondary
                                    pointer-events-none"
                            />
                            <input
                                type="date"
                                x-model="form.deadline"
                                class="date-input
                                    w-full
                                    rounded-2xl
                                    border-2 border-border
                                    bg-background
                                    px-5 py-3
                                    pr-12
                                    text-sm
                                    text-text-primary
                                    outline-none
                                    focus:border-primary"
                            >
                        </div>
                    </div> 
                    
                    {{-- Bg. Display Member --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="shadow-lg shadow-pastel-blue-background">
                                <x-lucide-users class="w-5 text-primary"/>
                            </div>
                            <div>
                                <p class="font-montserrat font-semibold text-sm text-text-primary">
                                    Team Members
                                </p>
                                <p class="text-xs text-text-secondary">
                                    Manage members in this project.
                                </p>
                            </div>
                        </div>

                        {{-- Bag. Peroject Leader --}}
                        <div class="bg-surface rounded-2xl p-4">
                            <p class="text-xs font-semibold text-text-primary mb-3">
                                Project Leader
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img
                                        :src="project.leader.avatar || '/images/profile.jpg'"
                                        class="w-10 h-10 rounded-full object-cover"
                                    >
                                    <div>
                                        <p
                                            class="font-semibold text-sm text-text-primary"
                                            x-text="project.leader.name"
                                        ></p>
                                        <p class="text-xs text-emerald-600">
                                            Project Leader
                                        </p>
                                    </div>
                                </div>
                                <x-lucide-crown
                                    class="w-5 h-5 text-yellow-500"
                                />
                            </div>
                        </div>

                        {{-- Search Members --}}
                        <div class="bg-surface rounded-2xl p-4 space-y-4">

                            {{-- Header --}}
                            <div class="flex items-center gap-2">
                                <div class="shadow-lg shadow-pastel-green-background">
                                    <x-lucide-user-plus class="w-5 text-primary"/>
                                </div>

                                <div>
                                    <p class="font-montserrat font-semibold text-sm text-text-primary">
                                        Add Members
                                    </p>

                                    <p class="text-xs text-text-secondary">
                                        Search by username or email to invite collaborators.
                                    </p>
                                </div>
                            </div>

                            {{-- Search --}}
                            <div class="space-y-2">

                                <p class="text-xs font-semibold text-text-primary font-montserrat">
                                    Search Users
                                </p>

                                <div class="relative">

                                    <x-lucide-search
                                        class="absolute left-4 top-1/2 -translate-y-1/2
                                            w-4 h-4 text-text-secondary"
                                    />

                                    <input
                                        type="text"
                                        x-model="memberQuery"
                                        @input="searchMembers()"
                                        placeholder="Username or email..."
                                        class="w-full
                                            rounded-xl
                                            border-2 border-border
                                            bg-background
                                            py-2.5 pl-11 pr-10
                                            text-sm
                                            text-text-primary
                                            outline-none
                                            focus:border-primary
                                            font-montserrat"
                                    >

                                    {{-- Clear --}}
                                    <button
                                        x-show="memberQuery.length"
                                        type="button"
                                        @click="
                                            memberQuery = '';
                                            memberSearchResults = [];
                                        "
                                        class="absolute
                                            right-3
                                            top-1/2
                                            -translate-y-1/2
                                            rounded-full
                                            p-1
                                            hover:bg-surface
                                            transition
                                            cursor-pointer"
                                    >
                                        <x-lucide-x class="w-4 h-4 text-text-secondary"/>
                                    </button>

                                </div>

                                {{-- Search Results --}}
                                <div
                                    x-show="memberSearchResults.length"
                                    x-transition
                                    class="rounded-xl
                                        border border-border
                                        bg-background
                                        shadow-lg
                                        overflow-hidden"
                                >

                                    <template
                                        x-for="user in memberSearchResults"
                                        :key="user.id"
                                    >

                                        <button
                                            type="button"
                                            @click="addMember(user)"
                                            class="w-full
                                                flex
                                                items-center
                                                gap-3
                                                px-4
                                                py-3
                                                hover:bg-surface
                                                transition
                                                cursor-pointer"
                                        >

                                            <img
                                                :src="user.avatar || '/images/profile.jpg'"
                                                class="w-9 h-9 rounded-full object-cover"
                                            >

                                            <div class="flex-1 text-left">

                                                <p
                                                    class="font-semibold text-sm text-text-primary"
                                                    x-text="user.name"
                                                ></p>

                                                <p
                                                    class="text-xs text-text-secondary"
                                                    x-text="user.email"
                                                ></p>

                                            </div>

                                            <div
                                                class="w-8 h-8
                                                    rounded-full
                                                    bg-primary/10
                                                    flex
                                                    items-center
                                                    justify-center"
                                            >
                                                <x-lucide-plus class="w-4 h-4 text-primary"/>
                                            </div>

                                        </button>

                                    </template>

                                </div>

                            </div>

                        </div>

                        {{-- Current Members --}}
                        <div class="bg-surface rounded-2xl p-4 space-y-3">

                            <div class="flex items-center justify-between">

                                <p class="text-xs font-semibold text-text-primary">
                                    Project Members
                                </p>

                                <span
                                    class="text-xs text-text-secondary"
                                    x-text="selectedMembers.length + ' members'"
                                ></span>

                            </div>

                            <div class="space-y-2 max-h-64 overflow-y-auto">

                                <template
                                    x-for="member in selectedMembers"
                                    :key="member.id"
                                >

                                    <div
                                        class="flex items-center justify-between
                                            rounded-xl
                                            bg-background
                                            border border-border
                                            px-3 py-2"
                                    >

                                        <div class="flex items-center gap-3">

                                            <img
                                                :src="member.avatar || '/images/profile.jpg'"
                                                class="w-10 h-10 rounded-full object-cover"
                                            >

                                            <div>

                                                <p
                                                    class="font-semibold text-sm text-text-primary"
                                                    x-text="member.name"
                                                ></p>

                                                <p
                                                    class="text-xs text-text-secondary"
                                                    x-text="member.email"
                                                ></p>

                                            </div>

                                        </div>

                                        <button
                                            x-show="member.id != project.leader_id"
                                            type="button"
                                            @click="removeMember(member.id)"
                                            class="w-8
                                                h-8
                                                rounded-full
                                                hover:bg-red-50
                                                dark:hover:bg-red-500/10
                                                transition
                                                cursor-pointer"
                                        >
                                            <x-lucide-x class="w-4 h-4 text-red-500 mx-auto"/>
                                        </button>

                                    </div>

                                </template>

                                <template x-if="selectedMembers.length === 0">

                                    <div
                                        class="rounded-xl
                                            border-2
                                            border-dashed
                                            border-border
                                            py-8
                                            text-center"
                                    >

                                        <x-lucide-users
                                            class="w-8 h-8 mx-auto text-text-secondary mb-2"
                                        />

                                        <p class="text-sm text-text-secondary">
                                            No project members.
                                        </p>

                                    </div>

                                </template>

                            </div>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="border-t-2 border-border px-6 py-4 flex justify-end gap-3 shrink-0">

                        <button
                            type="button"
                            @click="closeAll()"
                            class="px-5 py-2.5
                                rounded-2xl
                                border-2 border-border
                                bg-background
                                text-text-primary
                                font-semibold
                                font-montserrat
                                hover:bg-surface
                                transition
                                cursor-pointer"
                        >
                            Cancel
                        </button>

                        <button
                            type="button"
                            @click="saveProject()"
                            class="px-5 py-2.5
                                rounded-2xl
                                bg-quartiary
                                text-white
                                font-semibold
                                font-montserrat
                                hover:bg-quartiary-hover
                                transition
                                cursor-pointer"
                        >
                            Save Changes
                        </button>
                    </div>
                </div>
            </div> 
        </div> 
    
        {{-- DELETE PROJECT MODAL --}}
        <div
            x-show="showDelete"
            x-transition.opacity
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-5 backdrop-blur-sm">


            <div
                @click.outside="closeAll()"
                class="bg-background rounded-3xl p-6 w-full max-w-md font-montserrat">


                <h2 class="text-xl font-bold mb-3">
                    Delete Project?
                </h2>


                <p class="mb-6 text-gray-400">
                    This action cannot be undone.
                </p>


                <div class="flex gap-3 font-montserrat">

                    <button
                        @click="closeAll()"
                        class="flex-1 border rounded-xl py-3 cursor-pointer hover:bg-surface">
                        Cancel
                    </button>


                    <button
                        @click="deleteProject()"
                        class="flex-1 bg-red-500 text-white rounded-xl py-3 hover:bg-red-accent cursor-pointer">
                        Delete
                    </button>

                </div>


            </div>

        </div>
    </div>

    {{-- PRIORITY TASKS --}}
    @if ($priorityTasks->isNotEmpty())
        <div x-data="{showTaskModal:false, showCreateModal:false}" class="p-8 py-6">
            <h1 class="font-montserrat text-text-primary text-2xl font-bold">{{ __('main.task.top-priorities') }}</h1>
            
            <div class="flex flex-nowrap overflow-x-auto gap-5 pt-4 pb-4">
                @foreach ($priorityTasks as $task)
                    <div class="shrink-0 w-70 sm:w-[320px]">
                        @include('projects.tasks.priority-card', [
                            'status' => $task['status'],
                            'title' => $task['title'],
                            'dueDate' => $task['deadline'],
                            'daysLeft' => floor(now()->diffInDays($task->deadline, false)),
                            'priority' => $task['priority']
                        ])
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="py-3"></div>
    @endif


    {{-- TASKS LIST --}}
    @if($allTasks->isNotEmpty())
        <div class="px-8 pb-10" 
            x-data="taskModal()">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <h1 class="font-montserrat text-text-primary text-2xl font-bold mb-3 sm:mb-0">{{ __('main.task.all-tasks') }}</h1>
                
                <div class="flex gap-4">

                    {{-- SORT BUTTON --}}

                    <form method="GET" class="flex gap-3">

                        {{-- Preserve current direction when changing sort --}}
                        <input
                            id="directionInput"
                            type="hidden"
                            name="direction"
                            value="{{ request('direction', 'desc') }}"
                        >

                        {{-- Direction Toggle --}}
                        <button
                            type="submit"
                            name="direction"
                            value="{{ request('direction', 'desc') === 'asc' ? 'desc' : 'asc' }}"
                            onclick="document.getElementById('directionInput').disabled = true"
                            class="bg-background rounded-2xl p-2 shadow-sm hover:bg-surface transition-colors"
                        >
                            <x-lucide-arrow-up-down class="w-5 h-5 text-text-primary" />
                        </button>

                        {{-- Sort Dropdown --}}
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="bg-background rounded-3xl px-3 shadow-sm font-montserrat text-sm text-text-primary hover:bg-surface transition-colors focus:outline-none"
                        >
                            <option value="priority" {{ request('sort', 'priority') == 'priority' ? 'selected' : '' }}>
                                {{ __('main.task.priority') }}
                            </option>

                            <option value="alphabetical" {{ request('sort') == 'alphabetical' ? 'selected' : '' }}>
                                {{ __('main.task.alphabetical') }}
                            </option>

                            <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>
                                {{ __('main.task.deadline') }}
                            </option>
                        </select>

                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 items-start">
                @foreach ($allTasks as $task)
                    @include('projects.tasks.card', [
                        'project' => $project,
                        'task' => $task,
                    ]) 
                @endforeach
            </div>

            {{-- Task Detail Modal --}}
            <div
                x-show="show"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 shadow-2xl backdrop-blur-sm p-6"
            >

                {{-- Aksen Hijau  --}}
                <div class="absolute -top-24 left-3/4
                    h-64 w-86 -translate-x-1/2
                    rounded-full bg-emerald-300/15
                    blur-3xl">
                </div>

                <div
                    @click.outside="close()"
                    class="bg-background rounded-3xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden"
                >

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between px-6 py-5 border-b-2 border-border shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="flex justify-center items-center w-10 h-10 border-pastel-green-text bg-pastel-green-background border-2 p-2 rounded-2xl shadow-3xl shadow-[0_10px_30px_rgba(0,0,0,0.12)]">
                                <x-lucide-folder-bookmark class="w-6 text-pastel-green-text"/>
                            </div>
                            <div>
                                <h1 class="font-montserrat text-2xl font-bold text-text-primary"
                                    x-text="editing ? '{{ __('main.task.edit-task') }}' : '{{ __('main.task.task-detail') }}'">
                                </h1>
                                <p class="text-text-secondary text-sm"
                                    x-text="editing ? '{{ __('main.task.update-task-info') }}' : '{{ __('main.task.view-task-info') }}'">
                                </p>
                            </div>
                        </div>

                        <button
                            @click="close()"
                            class="w-12 h-12 rounded-full hover:bg-surface flex items-center justify-center hover:rotate-90 rotate-0 transition duration-300 cursor-pointer"
                        >
                            <x-lucide-x class="w-5 h-5 text-text-primary"/>
                        </button>
                    </div>

                    {{-- BODY --}}
                    <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">

                        {{-- Task Image --}}

                        <div class="space-y-2">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                {{ __('main.task.task-image') }}
                            </p>

                            <template x-if="!editing">
                                <div class="rounded-2xl overflow-hidden border-2 border-border bg-background w-50">
                                    <img
                                        :src="
                                            task.image_preview
                                                ? task.image_preview
                                                : (
                                                    task.image && task.image.startsWith('/images/')
                                                        ? task.image
                                                        : '/storage/' + task.image
                                                )
                                        "
                                        class="w-full h-24 object-cover"
                                    >
                                </div>
                            </template>

                            <template x-if="editing">
                                <div class="rounded-2xl border-2 border-dashed border-border bg-background p-4">
                                    <div class="flex items-center gap-5">
                                        <img
                                            :src="
                                                task.image_preview
                                                    ? task.image_preview
                                                    : (
                                                        task.image && task.image.startsWith('/images/')
                                                            ? task.image
                                                            : '/storage/' + task.image
                                                    )
                                            "
                                            class="w-40 h-28 rounded-xl object-cover border border-border shrink-0"
                                        >

                                        <div class="flex flex-col justify-center gap-3 flex-1 font-montserrat">

                                            <div>
                                                <p class="font-semibold text-md text-text-primary">
                                                    {{ __('main.task.replace-image') }}
                                                </p>

                                                <p class="text-sm text-text-secondary mt-1">
                                                    {{ __('main.task.upload-image-hint') }}
                                                </p>
                                            </div>

                                            <label
                                                class="inline-flex w-fit items-center gap-2
                                                    rounded-xl bg-primary px-4 py-2
                                                    text-sm font-medium text-white
                                                    cursor-pointer hover:bg-primary-hover transition"
                                            >
                                                <x-lucide-upload class="w-4 h-4"/>

                                                <span>{{ __('main.task.choose-image') }}</span>

                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    @change="previewTaskImage($event)"
                                                    class="hidden"
                                                >
                                            </label>

                                            <p class="text-[11px] text-text-secondary">
                                                {{ __('main.task.image-formats') }}
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Title --}}
                        <div>
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                {{ __('main.task.task-title') }}
                            </p>
                            <div class="bg-surface rounded-xl px-5 py-2 mt-1">
                                <template x-if="!editing">
                                    <p class="font-montserrat text-sm text-text-primary"
                                        x-text="task.title"
                                    ></p>
                                </template>
                                <template x-if="editing">
                                    <input type="text" x-model="task.title"
                                        class="w-full bg-transparent outline-none text-sm font-montserrat text-text-primary"
                                    >
                                </template>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                {{ __('main.task.description') }}
                            </p>
                            <div class="bg-surface rounded-xl px-5 py-3 mt-1">
                                <template x-if="!editing"> 
                                    <p
                                        class="font-montserrat text-sm text-text-primary whitespace-pre-line leading-7"
                                        x-text="task.description"
                                    ></p>
                                </template>
                                <template x-if="editing"> 
                                    <textarea
                                        x-model="task.description"
                                        x-init="$nextTick(() => {
                                            $el.style.height = '0px';
                                            $el.style.height = $el.scrollHeight + 'px';
                                        })"
                                        @input="
                                            $el.style.height = '0px';
                                            $el.style.height = $el.scrollHeight + 'px';
                                        "
                                        class="w-full bg-transparent resize-none overflow-hidden outline-none text-sm font-montserrat text-text-primary"
                                    ></textarea>
                                </template>
                            </div>
                        </div>

                        {{-- GRID --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Collaborator --}}
                                <div>
                                    <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                        {{ __('main.task.collaborators') }}
                                    </p>

                                    <template x-if="!editing">
                                        <div
                                            class="mt-1 bg-surface rounded-2xl px-4 py-3"
                                            x-data="{ showMembers: false }"
                                        >
                                            {{-- Top Row --}}
                                            <div class="flex items-center justify-between pl-2">
                                                {{-- Tumpukan avatar --}}
                                                <div class="flex items-center">
                                                    {{-- Mobile --}}
                                                    <div class="flex lg:hidden">
                                                        <template x-for="member in (task.members ?? []).slice(0,3)" :key="member.id">
                                                            <img
                                                                :src="member.avatar ? member.avatar : '/images/profile.jpg'"
                                                                class="w-8 h-8 shrink-0 min-w-8 rounded-full object-cover border-2 border-surface first:ml-1 -ml-2.5"
                                                            >
                                                        </template>
                                                        <template x-if="(task.members || []).length > 3">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-background border-2 border-surface flex items-center justify-center text-xs font-semibold -ml-2.5"
                                                            >
                                                                <span x-text="'+' + ((task.members || []).length - 3)"></span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                    {{-- Desktop --}}
                                                    <div class="hidden lg:flex">
                                                        <template x-for="member in (task.members ?? []).slice(0,5)" :key="member.id">
                                                            <img
                                                                :src="member.avatar ? member.avatar : '/images/profile.jpg'"
                                                                class="w-8 h-8 min-w-8 shrink-0 rounded-full object-cover border-2 border-surface first:ml-0 -ml-2.5"
                                                            >
                                                        </template>

                                                        <template x-if="(task.members || []).length > 5">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-background border-2 border-surface flex items-center justify-center text-xs font-semibold -ml-2.5"
                                                            >
                                                                <span x-text="'+' + ((task.members || []).length - 5)"></span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                </div>

                                                {{-- Expand Button --}}
                                                <button
                                                    @click="showMembers = !showMembers"
                                                    class="flex items-center gap-1 text-hyperlink hover:opacity-80 transition text-sm font-medium"
                                                >
                                                    <span
                                                        class="cursor-pointer font-montserrat"
                                                        x-text="showMembers
                                                            ? 'Hide'
                                                            : `View all (${(task.members || []).length})`">
                                                    </span>

                                                    <x-lucide-chevron-down
                                                        class="w-4 h-4 transition-transform duration-200"
                                                        ::class="{ 'rotate-180': showMembers }"
                                                    />
                                                </button>

                                            </div>

                                            {{-- Expandable members (view all members) --}}
                                            <div
                                                x-show="showMembers"
                                                x-collapse
                                                class="mt-4 border-t-2 border-border pt-3"
                                            >
                                                <div class="max-h-56 overflow-y-auto space-y-2 pr-1"
                                                >
                                                    <template
                                                        x-for="member in task.members"
                                                        :key="member.id"
                                                    >
                                                        <div class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-background transition"
                                                        >
                                                            <div class="flex items-center gap-3">
                                                                <img
                                                                    :src="member.avatar ? member.avatar : '/images/profile.jpg'"
                                                                    class="w-6 h-6 min-w-6 shrink-0 rounded-full object-cover"
                                                                >
                                                                <div>
                                                                    <p
                                                                        class="font-montserrat text-sm font-semibold text-text-primary"
                                                                        x-text="member.name"
                                                                    ></p>

                                                                    <p
                                                                        x-show="member.id == task.leader_id"
                                                                        class="text-xs text-emerald-600"
                                                                    >
                                                                        {{ __('main.task.project-leader') }}
                                                                    </p>

                                                                </div>

                                                            </div>

                                                            <x-lucide-crown
                                                                x-show="member.id == task.leader_id"
                                                                class="w-4 h-4 text-yellow-500"
                                                            />

                                                        </div>

                                                    </template>

                                                </div>

                                            </div>

                                        </div>
                                    </template>

                                    <template x-if="editing">
                                        <div
                                            class="bg-surface rounded-2xl p-4 space-y-4"
                                        >
                                            {{-- Header --}}
                                            <div class="flex items-center gap-2">
                                                <div class="shadow-2xl shadow-pastel-blue-background">
                                                    <x-lucide-users class="w-5 text-primary"/>
                                                </div>

                                                <div>
                                                    <p class="font-montserrat text-sm font-semibold text-text-primary">
                                                        {{ __('main.task.collaborators') }}
                                                    </p>

                                                    <p class="text-xs text-text-secondary font-montserrat">
                                                        {{ __('main.task.manage-members-hint') }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Search --}}
                                            <div class="space-y-1">

                                                <p class="text-xs font-semibold text-text-primary font-montserrat">
                                                    {{ __('main.task.search-users') }}
                                                </p>

                                                <div class="relative">

                                                    <x-lucide-search
                                                        class="absolute left-4 top-1/2 -translate-y-1/2
                                                            w-4 h-4 text-text-secondary"
                                                    />

                                                    <input
                                                        type="text"
                                                        x-model="assignedMemberQuery"
                                                        @input="searchAssignedMembers()"
                                                        placeholder="{{ __('main.ph.username-email') }}"
                                                        class="w-full rounded-xl
                                                            border-2 border-border
                                                            bg-background
                                                            py-2.5 pl-11 pr-10
                                                            text-[12px]
                                                            text-text-primary
                                                            outline-none
                                                            focus:border-primary font-montserrat"
                                                    >

                                                    <button
                                                        x-show="assignedMemberQuery.length"
                                                        @click="
                                                            assignedMemberQuery = '';
                                                            assignedSearchResults = [];
                                                        "
                                                        type="button"
                                                        class="absolute right-3 top-1/2
                                                            -translate-y-1/2
                                                            rounded-full p-1
                                                            hover:bg-surface cursor-pointer"
                                                    >
                                                        <x-lucide-x class="w-4 h-4 text-text-primary"/>
                                                    </button>

                                                    {{-- Dropdown --}}
                                                    <div
                                                        x-show="assignedSearchResults.length"
                                                        x-transition
                                                        class="absolute left-0 right-0 top-full mt-2
                                                            rounded-xl border border-border
                                                            bg-background
                                                            shadow-xl
                                                            overflow-hidden
                                                            z-50"
                                                    >

                                                        <template
                                                            x-for="user in assignedSearchResults"
                                                            :key="user.id"
                                                        >

                                                            <button
                                                                type="button"
                                                                @click="addAssignedMember(user)"
                                                                class="w-full
                                                                    flex items-center gap-2
                                                                    px-2 py-3
                                                                    hover:bg-surface
                                                                    transition"
                                                            >

                                                                <img
                                                                    :src="user.avatar || '/images/profile.jpg'"
                                                                    class="w-6 h-6 rounded-full object-cover"
                                                                >

                                                                <div class="flex flex-col text-left">

                                                                    <span
                                                                        class="font-semibold text-sm text-text-primary font-montserrat"
                                                                        x-text="user.name"
                                                                    ></span>

                                                                    <span
                                                                        class="text-[10px] text-text-secondary font-montserrat"
                                                                        x-text="user.email"
                                                                    ></span>

                                                                </div>

                                                            </button>

                                                        </template>

                                                    </div>

                                                </div>

                                            </div>

                                            {{-- Selected members --}}
                                            <div class="space-y-2">

                                                <p class="text-xs font-semibold text-text-primary">
                                                    {{ __('main.task.assigned-members') }}
                                                </p>

                                                <template
                                                    x-for="member in assignedMembers"
                                                    :key="member.id"
                                                >

                                                    <div
                                                        class="flex items-center justify-between
                                                            rounded-xl
                                                            bg-background
                                                            px-3 py-2
                                                            border border-border"
                                                    >

                                                        <div class="flex items-center gap-3">

                                                            <img
                                                                :src="member.avatar || '/images/profile.jpg'"
                                                                class="w-9 h-9 rounded-full object-cover"
                                                            >

                                                            <div>

                                                                <p
                                                                    class="font-medium text-sm text-text-primary"
                                                                    x-text="member.name"
                                                                ></p>

                                                                <p
                                                                    x-show="member.id == task.leader_id"
                                                                    class="text-xs text-emerald-600"
                                                                >
                                                                    {{ __('main.task.project-leader') }}
                                                                </p>

                                                            </div>

                                                        </div>

                                                        <button
                                                            type="button"
                                                            @click="removeAssignedMember(member.id)"
                                                            class="w-8 h-8
                                                                rounded-full
                                                                hover:bg-red-50
                                                                text-red-500
                                                                transition"
                                                        >
                                                            <x-lucide-x class="w-4 h-4 mx-auto"/>
                                                        </button>

                                                    </div>

                                                </template>

                                            </div>

                                        </div>

                                    </template>
                                </div>

                            {{-- Status --}}
                            <div>
                                <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                    {{ __('main.task.status') }}
                                </p>
                                <div class="bg-surface rounded-2xl px-4 py-3 mt-1">
                                    <!-- View -->
                                    <template x-if="!editing">
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full font-semibold text-sm"
                                            :class="{
                                                'bg-blue-100 text-blue-700': task.status === 'pending',
                                                'bg-orange-100 text-orange-700': task.status === 'in_progress',
                                                'bg-green-100 text-green-700': task.status === 'completed',
                                                'bg-red-100 text-red-700': task.status === 'cancelled'
                                            }"
                                        >
                                            <div class="w-2 h-2 rounded-full"
                                                :class="{
                                                    'bg-blue-700': task.status === 'pending',
                                                    'bg-orange-700': task.status === 'in_progress',
                                                    'bg-green-700': task.status === 'completed',
                                                    'bg-red-700': task.status === 'cancelled'
                                                }"    
                                            ></div>
                                            <span
                                                x-text="task.status === 'completed'
                                                    ? '{{ __('main.task.completed') }}'
                                                    : (task.status === 'in_progress'
                                                        ? '{{ __('main.task.in-progress') }}'
                                                        : (task.status === 'pending'
                                                            ? '{{ __('main.task.pending') }}'
                                                            : '{{ __('main.task.cancelled') }}'))"
                                            ></span>
                                        </span>
                                    </template>

                                    <!-- Edit -->
                                    <div x-show="editing" class="grid grid-cols-2 gap-2 mt-1">
                                        <button
                                            @click="task.status='pending'"
                                            :class="task.status == 'pending'
                                                ? 'bg-blue-accent text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            {{ __('main.task.pending') }}
                                        </button>
                                        <button
                                            @click="task.status='in_progress'"
                                            :class="task.status == 'in_progress'
                                                ? 'bg-yellow-accent text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            {{ __('main.task.in-progress') }}
                                        </button>
                                        <button
                                            @click="task.status='completed'"
                                            :class="task.status == 'completed'
                                                ? 'bg-quartiary text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            {{ __('main.task.completed') }}
                                        </button>
                                        <button
                                            @click="task.status='cancelled'"
                                            :class="task.status == 'cancelled'
                                                ? 'bg-red-accent text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            {{ __('main.task.cancelled') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Deadline --}}
                            <div>
                                <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                    {{ __('main.task.deadline') }}
                                </p>
                                <template x-if="!editing">
                                    <div class="bg-surface rounded-2xl px-4 py-3 mt-1">
                                        <div class="flex items-center gap-3">
                                            <x-lucide-calendar class="w-4.5 h-4.5 text-text-secondary"/>
                                            <span
                                                class="text-sm text-text-primary font-montserrat"
                                                x-text="task.deadline"
                                            ></span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="editing">
                                    <div class="relative">
                                        {{-- Custom icon --}}
                                        <x-lucide-calendar
                                            class="absolute right-4 top-1/2 -translate-y-1/2
                                                w-4.5 h-4.5 text-text-secondary pointer-events-none z-10"
                                        />
                                        <input
                                            type="date"
                                            x-model="task.deadline"
                                            class="date-input w-full rounded-xl
                                                border-2 border-border
                                                bg-background
                                                px-4 py-2 pr-12
                                                text-sm text-text-primary
                                                outline-none
                                                focus:ring-2 focus:ring-primary
                                                focus:border-primary z-0"
                                        >
                                    </div>
                                </template>
                            </div>

                            {{-- Priority --}}
                            <div>
                                <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                    {{ __('main.task.priority') }}
                                </p>
                                <template x-if="!editing">
                                    <div class="bg-surface rounded-2xl px-4 py-3 mt-1">
                                        <span
                                            class="px-3 py-1 rounded-full text-white text-sm font-semibold"
                                            :class="{
                                                'bg-red-accent': task.priority == 'high',
                                                'bg-yellow-accent': task.priority == 'medium',
                                                'bg-quartiary': task.priority == 'low'
                                            }"
                                            x-text="task.priority === 'high' ? '{{ __('main.task.high') }}' : (task.priority === 'medium' ? '{{ __('main.task.medium') }}' : '{{ __('main.task.low') }}')"
                                        ></span>
                                    </div>
                                </template>
                                <template x-if="editing">
                                    <div class="grid grid-cols-3 gap-2 mt-1">

                                        <button
                                            type="button"
                                            @click="task.priority = 'high'"
                                            :class="task.priority === 'high'
                                                ? 'bg-red-accent text-white border-red-accent'
                                                : 'bg-background border-border text-text-primary'"
                                            class="rounded-xl border-2 py-1.75 text-[12px] transition cursor-pointer"
                                        >
                                            {{ __('main.task.high') }}
                                        </button>

                                        <button
                                            type="button"
                                            @click="task.priority = 'medium'"
                                            :class="task.priority === 'medium'
                                                ? 'bg-yellow-accent text-white border-yellow-accent'
                                                : 'bg-background border-border text-text-primary'"
                                            class="rounded-xl border-2 py-1.75 text-[12px] transition cursor-pointer"
                                        >
                                            {{ __('main.task.medium') }}
                                        </button>

                                        <button
                                            type="button"
                                            @click="task.priority = 'low'"
                                            :class="task.priority === 'low'
                                                ? 'bg-quartiary text-white border-quartiary'
                                                : 'bg-background border-border text-text-primary'"
                                            class="rounded-xl border-2 py-1.75 text-[12px] transition cursor-pointer"
                                        >
                                            {{ __('main.task.low') }}
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- GO COLLAB --}}
                        <div>
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                {{ __('main.task.go-collab') }}
                            </p>

                            <div
                                class="mt-1 bg-surface rounded-2xl px-4 py-3"
                            >
                                {{-- SUMMARY --}}
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center"
                                        >
                                            <x-lucide-users
                                                class="w-5 h-5 text-primary"
                                            />
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="font-montserrat text-sm font-semibold text-text-primary"
                                                >
                                                    {{ __('main.task.go-collab') }}
                                                </span>
                                                <span
                                                    class="px-2 py-0.5 rounded-full text-xs font-semibold"
                                                    :class="task.go_collab_enabled
                                                        ? 'bg-green-100 text-green-700'
                                                        : 'bg-gray-200 text-gray-600'"
                                                    x-text="task.go_collab_enabled ? '{{ __('main.task.enabled') }}' : '{{ __('main.task.disabled') }}'"
                                                ></span>
                                            </div>
                                            <template x-if="task.go_collab_enabled">
                                                <p
                                                    class="text-xs text-text-secondary mt-0.5"
                                                    x-text="`${task.go_collab_reward} {{ __('main.task.credits') }} • {{ __('main.task.max') }} ${task.go_collab_limit} {{ __('main.task.collaborators-lc') }}`"
                                                ></p>
                                            </template>
                                        </div>
                                    </div>

                                    {{-- Expand --}}
                                    <div class="flex items-center justify-between font-montserrat">

                                        <!-- Viewing -->
                                        <template x-if="!editing && task.go_collab_enabled">
                                            <button
                                                @click="showCollab = !showCollab"
                                                class="flex items-center gap-1 text-hyperlink text-sm font-medium cursor-pointer"
                                            >
                                                <span x-text="showCollab ? 'Hide' : 'View Details'"></span>

                                                <x-lucide-chevron-down
                                                    class="w-4 h-4 transition-transform"
                                                    ::class="{ 'rotate-180': showCollab }"
                                                />
                                            </button>
                                        </template>

                                        <!-- Editing -->
                                        <template x-if="editing">
                                            <div>
                                                <button
                                                    type="button"
                                                    @click="
                                                        if (Boolean(task.go_collab_enabled)) {
                                                            showDisableCollabWarning = true;
                                                        } else {
                                                            task.go_collab_enabled = true;
                                                            showCollab = true;
                                                        }
                                                    "
                                                    class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors cursor-pointer"
                                                    :class="task.go_collab_enabled
                                                        ? 'bg-primary'
                                                        : 'bg-gray-300 dark:bg-gray-600'"
                                                >
                                                    <span
                                                        class="inline-block h-5 w-5 rounded-full bg-white transition-transform"
                                                        :class="task.go_collab_enabled
                                                            ? 'translate-x-6'
                                                            : 'translate-x-1'"
                                                    ></span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- DETAILS --}}
                                <div
                                    x-show="showCollab"
                                    x-collapse
                                    class="mt-5 border-t-2 border-border pt-4 space-y-5"
                                >
                                    {{-- Description --}}
                                    <div>
                                        <p
                                            class="font-montserrat font-semibold text-xs text-text-primary mb-2"
                                        >
                                            {{ __('main.task.description') }}
                                        </p>
                                        <template x-if="!editing">
                                            <div
                                                class="rounded-xl bg-background px-4 py-3"
                                            >
                                                <p
                                                    class="text-sm text-text-primary font-montserrat whitespace-pre-line"
                                                    x-text="task.go_collab_description || '{{ __('main.task.no-description') }}'"
                                                ></p>
                                            </div>
                                        </template>
                                        <template x-if="editing">
                                            <textarea
                                                x-model="task.go_collab_description"
                                                rows="3"
                                                class="w-full rounded-xl bg-background text-text-primary px-4 py-3 resize-none outline-none border-2 border-border focus:border-primary"
                                            ></textarea>
                                        </template>
                                    </div>

                                    {{-- GRID --}}
                                    <div class="grid md:grid-cols-2 gap-4">
                                        {{-- Reward --}}
                                        <div>
                                            <p
                                                class="font-montserrat font-semibold text-xs text-text-primary mb-2"
                                            >
                                                {{ __('main.task.credit-reward') }}
                                            </p>
                                            <template x-if="!editing">
                                                <div class="bg-background rounded-xl px-4 py-3 text-text-primary">
                                                    <span
                                                        class="font-montserrat text-sm text-text-primary"
                                                        x-text="task.go_collab_reward
                                                            ? task.go_collab_reward + ' {{ __('main.task.credits') }}'
                                                            : '{{ __('main.task.undefined') }}'"
                                                    ></span>
                                                </div>
                                            </template>
                                            <template x-if="editing">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    x-model="task.go_collab_reward"
                                                    class="w-full rounded-xl border-2 border-border text-text-primary bg-background px-4 py-2.5 outline-none focus:border-primary"
                                                >
                                            </template>
                                        </div>

                                        {{-- Maximum Collaborators --}}
                                        <div>
                                            <p
                                                class="font-montserrat font-semibold text-xs text-text-primary mb-2"
                                            >
                                                {{ __('main.task.max-collaborators') }}
                                            </p>
                                            <template x-if="!editing">
                                                <div class="bg-background rounded-xl px-4 py-3">
                                                    <span
                                                        class="font-montserrat text-sm text-text-primary"
                                                        x-text="task.go_collab_limit ?? '{{ __('main.task.undefined') }}'"
                                                    ></span>

                                                </div>

                                            </template>

                                            <template x-if="editing">

                                                <input
                                                    type="number"
                                                    min="1"
                                                    x-model="task.go_collab_limit"
                                                    class="w-full rounded-xl border-2 border-border text-text-primary bg-background px-4 py-2.5 outline-none focus:border-primary"
                                                >

                                            </template>

                                        </div>

                                    </div>

                                    {{-- Participants --}}
                                    <div>

                                        <div class="flex items-center justify-between mb-2">

                                            <p
                                                class="font-montserrat font-semibold text-xs text-text-primary"
                                            >
                                                {{ __('main.task.current-participants') }}
                                            </p>

                                            <span
                                                class="text-xs text-text-secondary"
                                                x-text="task.go_collab_limit != null
                                                    ? `${task.members?.length ?? 0} / ${task.go_collab_limit}`
                                                    : ''"
                                                {{-- x-text="`${task.collaborators?.length ?? 0} / ${task.go_collab_limit}`" --}}
                                            ></span>
                                        </div>

                                        <div
                                            class="bg-background rounded-xl p-3 max-h-48 overflow-y-auto space-y-2"
                                        >
                                            <template
                                                x-for="user in task.collaborators"
                                                :key="user.id"
                                            >
                                                <div
                                                    class="flex items-center justify-between rounded-lg px-2 py-2 hover:bg-surface transition"
                                                >
                                                    <div class="flex items-center gap-3">
                                                        <img
                                                            :src="user.avatar || '/images/profile.jpg'"
                                                            class="w-8 h-8 rounded-full object-cover"
                                                        >
                                                        <div>
                                                            <p
                                                                class="text-sm font-semibold text-text-primary"
                                                                x-text="user.name"
                                                            ></p>
                                                            <p
                                                                class="text-xs text-text-secondary"
                                                                x-text="user.pivot.status === 'declined' ?
                                                                    '{{ __('main.task.declined') }}' : (user.pivot.status === 'completed' ?
                                                                        '{{ __('main.task.completed') }}' : '{{ __('main.task.in-progress') }}')"
                                                            ></p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-2">
                                                        <!-- hadiah -->
                                                        <template x-if="!editing">
                                                            <span
                                                                class="text-xs font-semibold text-primary"
                                                                x-text="user.pivot.reward_earned + ' pts'"
                                                            ></span>
                                                        </template>

                                                        <!-- Hapus collaborator -->
                                                        <template x-if="editing">
                                                            <button
                                                                type="button"
                                                                @click="removeCollaborator(user.id)"
                                                                class="w-8 h-8 rounded-full hover:bg-red-50 dark:hover:bg-red-500/15
                                                                    flex items-center justify-center transition-colors"
                                                            >
                                                                <x-lucide-x class="w-4 h-4 text-red-500"/>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <template
                                                x-if="!task.collaborators || task.collaborators.length === 0"
                                            >

                                                <p
                                                    class="text-sm text-center text-text-secondary font-montserrat py-2"
                                                >
                                                    {{ __('main.task.no-collaborators') }}
                                                </p>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <template x-if="!editing">
                            <button
                                type="button"
                                @click="
                                    showDeleteTaskWarning = true;
                                "
                                class="flex items-center justify-center gap-2
                                    rounded-xl
                                    px-5 py-3
                                    text-sm font-semibold
                                    text-pastel-red-text
                                    font-montserrat
                                    border-2 border-pastel-red-text
                                    hover:bg-surface
                                    transition
                                    w-full
                                    cursor-pointer"
                            >
                                <x-lucide-trash-2 class="w-4 h-4"/>

                                {{ __('main.task.delete-task') }}
                            </button>
                        </template>

                    </div>

                    <template x-if="showDeleteTaskWarning">
                        <div
                            class="fixed inset-0 z-100 bg-black/40 flex items-center justify-center backdrop-blur-sm p-6"
                            @click="showDeleteTaskWarning = false"
                        >

                            <div
                                class="bg-background rounded-2xl p-6 max-w-md w-full shadow-xl"
                                @click.stop
                            >

                                <h3 class="text-lg font-semibold text-text-primary font-montserrat">
                                    {{ __('main.task.delete-task-confirm') }}
                                </h3>

                                <p
                                    class="mt-3 text-sm text-text-secondary leading-6 font-montserrat"
                                    x-text="`{{ __('main.task.delete-task-desc-1') }} ${(task.members ?? []).length} {{ __('main.task.delete-task-desc-2') }}`"
                                ></p>

                                <div class="flex justify-end gap-3 mt-6">

                                    <button
                                        type="button"
                                        @click="showDeleteTaskWarning = false"
                                        class="px-4 py-2 rounded-xl
                                            bg-background
                                            border-2 border-border
                                            text-sm text-text-primary
                                            font-montserrat
                                            hover:bg-surface
                                            cursor-pointer
                                            transition"
                                    >
                                        {{ __('main.task.cancel') }}
                                    </button>

                                    <button
                                        type="button"
                                        @click="
                                            showDeleteTaskWarning = false;
                                            deleteTask();
                                        "
                                        class="px-4 py-2 rounded-xl
                                            bg-red-500
                                            text-white
                                            text-sm
                                            font-montserrat
                                            hover:bg-red-accent
                                            cursor-pointer
                                            transition"
                                    >
                                        {{ __('main.task.delete-permanently') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Disable Warning Modal --}}
                    <template x-if="showDisableCollabWarning">
                        <div
                            class="fixed inset-0 z-100 bg-black/40 flex items-center justify-center backdrop-blur-sm"
                            @click="showDisableCollabWarning = false"
                        >
                            <div
                                class="bg-background rounded-2xl p-6 max-w-md w-full shadow-xl"
                                @click.stop
                            >

                                <h3 class="text-lg font-semibold text-text-primary font-montserrat">
                                    {{ __('main.task.disable-collab-confirm') }}
                                </h3>

                                <p class="mt-3 text-sm text-text-secondary leading-6 font-montserrat">
                                    {{ __('main.task.disable-collab-desc') }}
                                </p>

                                <div class="flex justify-end gap-3 mt-6">

                                    <button
                                        type="button"
                                        @click="showDisableCollabWarning = false"
                                        class="px-4 py-2 rounded-xl bg-background border-2 border-border text-sm text-text-primary font-montserrat hover:bg-surface cursor-pointer"
                                    >
                                        {{ __('main.task.cancel') }}
                                    </button>

                                    <button
                                        type="button"
                                        @click="
                                            task.go_collab_enabled = false;
                                            showCollab = false;
                                            showDisableCollabWarning = false;
                                        "
                                        class="px-4 py-2 rounded-xl bg-red-500 text-white text-sm font-montserrat hover:bg-red-accent cursor-pointer"
                                    >
                                        {{ __('main.task.disable') }}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- FOOTER --}}
                    <div class="border-t-2 border-border px-6 py-4 flex justify-between font-montserrat gap-3 shrink-0">
                        <div>
                            <template x-if="!editing">
                                <button
                                    @click="edit()"
                                    class="bg-quartiary text-white px-5 py-2.5 rounded-2xl hover:bg-quartiary-hover transition cursor-pointer"
                                >
                                    {{ __('main.task.edit-task') }}
                                </button>
                            </template>

                            <template x-if="editing">
                                <div class="flex gap-2">
                                
                                    <div class="relative group">
                                        <button
                                            type="button"
                                            @click="save()"
                                    
                                            :disabled="
                                                Boolean(task.go_collab_enabled) &&
                                                Number(task.go_collab_reward || 0) > Number(task.leader_points || 0)
                                            "

                                            :class="
                                                Boolean(task.go_collab_enabled) &&
                                                Number(task.go_collab_reward || 0) > Number(task.leader_points || 0)
                                                    ? 'bg-quartiary/40 cursor-not-allowed'
                                                    : 'bg-quartiary hover:bg-quartiary-hover cursor-pointer'
                                            "

                                            class="text-white px-5 py-2 rounded-2xl transition"
                                        >
                                            {{ __('main.task.save-changes') }}
                                        </button>
                                    
                                        <div
                                            x-show="
                                                Boolean(task.go_collab_enabled) &&
                                                Number(task.go_collab_reward || 0) > Number(task.leader_points || 0)
                                            "
                                            class="absolute bottom-full left-0 mb-2
                                                px-3 py-2
                                                bg-gray-900 text-white
                                                text-xs rounded-lg
                                                whitespace-nowrap
                                                opacity-0 group-hover:opacity-100
                                                pointer-events-none
                                                transition-opacity duration-200
                                                shadow-lg z-50">
                                            Insufficient credits. 
                                            <span
                                                class="font-semibold"
                                                x-text="
                                                    Number(task.go_collab_reward || 0) -
                                                    Number(task.leader_points || 0)
                                                "
                                            ></span>
                                            Credit(s) to go.
                                        </div>
                                    </div>
                                
                                    <button
                                        type="button"
                                        @click="cancelEdit()"
                                        class="border-2 border-red-accent text-red-accent cursor-pointer px-5 py-2.5 rounded-2xl transition hover:bg-surface bg-background font-montserrat font-semibold"
                                    >
                                        {{ __('main.task.cancel') }}
                                    </button>
                                
                                </div>
                            </template>
                        </div>
                        
                        <button
                            @click="close()"
                            class="border border-gray-200 px-5 py-2.5 rounded-2xl hover:bg-surface transition text-text-primary cursor-pointer ml-2"
                        >
                            {{ __('main.task.close') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- SUBMIT TASK FOR REVIEW MODAL --}}
            <div
                x-show="showCompleteModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
            >

                {{-- Green Accent --}}
                <div
                    class="absolute -top-24 left-3/4
                        h-64 w-86
                        -translate-x-1/2
                        rounded-full
                        bg-green-300/15
                        blur-3xl"
                ></div>

                <div
                    @click.outside="closeComplete()"
                    class="bg-background
                        rounded-3xl
                        shadow-xl
                        w-full
                        max-w-2xl
                        max-h-[90vh]
                        flex
                        flex-col
                        overflow-hidden"
                >

                    {{-- HEADER --}}
                    <div
                        class="flex items-center justify-between
                            px-6 py-5
                            border-b-2 border-border
                            shrink-0"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex justify-center items-center
                                    w-10 h-10
                                    rounded-2xl
                                    border-2
                                    border-green-600
                                    bg-mark-completed
                                    shadow-[0_10px_30px_rgba(34,197,94,.18)]"
                            >
                                <x-lucide-badge-check
                                    class="w-5 h-5 text-green-600"
                                />
                            </div>

                            <div>

                                <h1
                                    class="font-montserrat
                                        text-2xl
                                        font-bold
                                        text-text-primary"
                                >
                                    Submit for Review
                                </h1>

                                <p
                                    class="text-sm font-montserrat
                                        text-text-secondary"
                                >
                                    Submit your completed work for leader verification.
                                </p>

                            </div>

                        </div>

                        <button
                            @click="closeComplete()"
                            class="w-12 h-12
                                rounded-full
                                hover:bg-surface
                                flex
                                items-center
                                justify-center
                                z-101
                                transition
                                duration-300
                                cursor-pointer"
                        >
                            <x-lucide-x
                                class="w-5 h-5 text-text-primary"
                            />
                        </button>

                    </div>

                    {{-- BODY --}}
                    <div
                        class="flex-1
                            overflow-y-auto
                            px-6
                            py-5
                            space-y-5"
                    >

                        {{-- Task --}}
                        <div
                            class="bg-surface
                                rounded-2xl
                                p-5"
                        >

                            <p
                                class="text-xs
                                    font-semibold
                                    uppercase
                                    tracking-wider
                                    text-text-secondary"
                            >
                                Task
                            </p>

                            <h2
                                class="mt-2
                                    text-xl
                                    font-bold font-montserrat
                                    text-text-primary"
                                x-text="task.title"
                            ></h2>

                            <div
                                class="flex
                                    gap-2
                                    mt-4"
                            >

                                <span
                                    :class="
                                        task.priority === 'high' ? 'bg-red-accent' : (task.priority === 'Medium' ? 'bg-yellow-accent' : 'bg-quartiary')
                                    "
                                    class="px-3
                                        py-1
                                        rounded-full
                                        text-white leading-6
                                        text-xs
                                        font-montserrat
                                        font-semibold
                                        capitalize"
                                    x-text="task.priority === 'high' ? 'Priority: High' : (task.priority === 'Medium' ? 'Priority: Medium' : 'Priority: Low')" 
                                ></span>

                                <span
                                    class="px-3
                                        py-1
                                        flex items-center font-montserrat
                                        rounded-full
                                        bg-background
                                        text-text-primary
                                        text-xs"
                                    x-text="task.priority === 'high' ? '+30 Credit Point' : (task.priority === 'Medium' ? '+20 Credit Point' : '+10 Credit Point')"
                                ></span>

                            </div>

                        </div>

                        {{-- Team Submission --}}
                        <div
                            class="bg-mark-completed font-montserrat
                                rounded-2xl
                                p-5"
                        >

                            <div class="flex gap-4">

                                <div
                                    class="w-10
                                        h-10
                                        rounded-xl
                                        bg-white/60
                                        flex
                                        items-center
                                        justify-center
                                        shrink-0"
                                >
                                    <x-lucide-users
                                        class="w-5 h-5 text-green-700"
                                    />
                                </div>

                                <div>

                                    <h3
                                        class="font-semibold
                                            text-text-primary"
                                    >
                                        Team Submission
                                    </h3>

                                    <p
                                        class="text-sm
                                            text-text-secondary
                                            mt-1
                                            leading-6"
                                    >
                                        This submission represents the work of the entire
                                        team. Once submitted, the task will enter
                                        <strong>Pending Review</strong> until the project
                                        leader approves or rejects it.
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Divider --}}
                        <div class="border-t-2 border-border"></div>

                        {{-- Upload --}}
                        <div
                            class="bg-surface
                                rounded-2xl
                                p-5 font-montserrat
                                space-y-4"
                        >

                            <div class="flex items-center gap-2">

                                <x-lucide-image-plus
                                    class="w-5 h-5 text-green-600"
                                />

                                <h3
                                    class="font-semibold
                                        text-text-primary"
                                >
                                    Proof of Completion
                                </h3>

                            </div>

                            <label
                                class="border-2
                                    border-dashed
                                    border-border
                                    rounded-2xl
                                    h-60
                                    cursor-pointer
                                    hover:border-primary
                                    transition
                                    flex
                                    flex-col
                                    justify-center
                                    items-center
                                    bg-background
                                    overflow-hidden"
                            >

                                <template x-if="!submissionForm.preview">

                                    <div class="flex flex-col items-center">

                                        <x-lucide-upload-cloud
                                            class="w-12 h-12 text-text-secondary"
                                        />

                                        <p
                                            class="mt-4
                                                font-semibold
                                                text-text-primary"
                                        >
                                            Click to upload an image
                                        </p>

                                        <p
                                            class="text-sm
                                                text-text-secondary"
                                        >
                                            PNG • JPG • JPEG
                                        </p>

                                    </div>

                                </template>

                                <template x-if="submissionForm.preview">

                                    <img
                                        :src="submissionForm.preview"
                                        class="w-full h-full object-cover"
                                    >

                                </template>

                                <input
                                    type="file"
                                    accept="image/*"
                                    class="hidden"
                                    @change="previewSubmissionImage"
                                >

                            </label>

                        </div>

                        {{-- Link --}}
                        <div
                            class="bg-surface
                                rounded-2xl
                                p-5 font-montserrat
                                space-y-4"
                        >

                            <div class="flex items-center gap-2">

                                <x-lucide-link
                                    class="w-5
                                        h-5
                                        text-green-600"
                                />

                                <h3
                                    class="font-semibold
                                        text-text-primary"
                                >
                                    Submission Link
                                </h3>

                            </div>

                            <input
                                type="url"
                                x-model="submissionForm.link"
                                placeholder="https://github.com/your-project"
                                class="w-full
                                    rounded-2xl
                                    bg-background
                                    px-5
                                    py-3
                                    outline-none
                                    placeholder:text-placeholder
                                    text-text-primary
                                    text-sm
                                    border
                                    border-border
                                    focus:border-primary"
                            >

                            <p
                                class="text-xs
                                    text-text-secondary"
                            >
                                GitHub repository, Figma file, Google Drive,
                                YouTube, Notion page, etc.
                            </p>

                        </div>

                        {{-- Notes --}}
                        <div
                            class="bg-surface
                                rounded-2xl
                                p-5 font-montserrat
                                space-y-4"
                        >

                            <div class="flex items-center gap-2">

                                <x-lucide-square-pen
                                    class="w-5
                                        h-5
                                        text-green-600"
                                />

                                <h3
                                    class="font-semibold
                                        text-text-primary"
                                >
                                    Additional Notes
                                </h3>

                            </div>

                            <textarea
                                rows="5"
                                x-model="submissionForm.notes"
                                placeholder="Describe what has been completed..."
                                class="w-full
                                    rounded-2xl
                                    bg-background
                                    px-5
                                    py-4 text-sm
                                    resize-none
                                    text-text-primary
                                    placeholder:text-placeholder
                                    outline-none
                                    border
                                    border-border
                                    focus:border-primary"
                            ></textarea>

                        </div>

                        {{-- Reminder --}}
                        <div
                            class="rounded-2xl
                                border font-montserrat
                                border-border
                                bg-background
                                p-5"
                        >

                            <div class="flex gap-3">

                                <x-lucide-info
                                    class="w-5
                                        h-5
                                        text-primary
                                        shrink-0"
                                />

                                <p
                                    class="text-sm
                                        leading-6
                                        text-text-secondary"
                                >
                                    After submission, collaborators will no longer be able
                                    to submit another completion request until this one has
                                    been reviewed by the project leader.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div
                        class="flex
                            justify-end
                            gap-3
                            px-6
                            py-5 font-montserrat
                            border-t-2
                            border-border
                            shrink-0"
                    >

                        <button
                            @click="closeComplete()"
                            class="px-6
                                py-3 border-2 border-border
                                rounded-2xl
                                hover:bg-surface 
                                transition
                                text-text-primary
                                cursor-pointer"
                        >
                            Cancel
                        </button>

                        <button
                            @click="submitTask()"
                            :disabled="!submissionForm.image && !submissionForm.link"
                            :class="(!submissionForm.image && !submissionForm.link)
                                ? 'opacity-50 cursor-not-allowed'
                                : ''"
                            class="px-7
                                py-3
                                rounded-2xl
                                bg-quartiary
                                hover:bg-quartiary-hover
                                text-white
                                shadow-lg
                                shadow-green-600/20
                                transition
                                cursor-pointer"
                        >

                            <div class="flex items-center gap-2">

                                <x-lucide-send
                                    class="w-4 h-4"
                                />

                                <span>
                                    Submit for Review
                                </span>

                            </div>

                        </button>

                    </div>

                </div>

            </div>

            {{-- Submission Modal --}}

            <div
                x-show="showSubmissionModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
            >

                {{-- Green Accent --}}
                <div
                    class="absolute -top-24 left-3/4
                        h-64 w-86
                        -translate-x-1/2
                        rounded-full
                        bg-green-300/15
                        blur-3xl"
                ></div>

                <div
                    @click.outside="closeSubmission()"
                    class="bg-background rounded-3xl shadow-xl
                        w-full max-w-2xl
                        max-h-[90vh]
                        flex flex-col
                        overflow-hidden"
                >

                    <!-- HEADER -->
                    <div
                        class="flex items-center justify-between
                            px-6 py-5
                            border-b-2 border-border
                            shrink-0"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex justify-center items-center
                                    w-10 h-10
                                    rounded-2xl
                                    border-2
                                    border-green-600
                                    bg-mark-completed
                                    shadow-[0_10px_30px_rgba(34,197,94,.18)]"
                            >
                                <x-lucide-view
                                    class="w-5 h-5 text-green-600"
                                />
                            </div>

                            <div>
                                <h2 class="text-2xl font-bold font-montserrat text-text-primary">
                                    Submission Details
                                </h2>

                                <p class="text-sm text-text-secondary font-montserrat">
                                    Review the submitted work.
                                </p>
                            </div>

                        </div>

                        <button
                            @click="closeSubmission()"
                            class="w-11 h-11
                                rounded-full
                                hover:bg-surface
                                transition
                                z-101 text-text-primary
                                hover:rotate-90
                                flex items-center justify-center
                                cursor-pointer"
                        >
                            <x-lucide-x class="w-5 h-5"/>
                        </button>

                    </div>

                    <!-- BODY -->
                    <div
                        class="flex-1 overflow-y-auto
                            px-6 py-5 font-montserrat
                            space-y-6"
                    >

                        <!-- Task -->
                        <div class="font-montserrat">
                            <p class="text-xs font-semibold uppercase text-text-secondary">
                                Task
                            </p>

                            <div
                                class="mt-2
                                    bg-surface
                                    rounded-2xl
                                    px-5 py-4"
                            >
                                <h3
                                    class="font-semibold text-lg text-text-primary"
                                    x-text="submission.title"
                                ></h3>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="grid md:grid-cols-2 gap-4">

                            <div
                                class="bg-surface
                                    rounded-2xl
                                    p-5"
                            >

                                <div class="flex items-center gap-2 mb-3">
                                    <x-lucide-user class="w-5 h-5 text-primary"/>

                                    <p class="font-semibold text-text-primary">
                                        Submitted By
                                    </p>
                                </div>

                                <div class="flex items-center gap-3 bg-background rounded-xl p-2">
                                    <img
                                        :src="submission.submitter_avatar"
                                        class="w-8 h-8 rounded-full object-cover"
                                    >
                                    <p
                                        class="text-text-secondary"
                                        x-text="submission.submitter"
                                    ></p>
                                </div>

                            </div>

                            <div
                                class="bg-surface
                                    rounded-2xl
                                    p-5"
                            >

                                <div class="flex items-center gap-2 mb-3">
                                    <x-lucide-calendar-days class="w-5 h-5 text-primary"/>

                                    <p class="font-semibold text-text-primary">
                                        Submitted At
                                    </p>
                                </div>
                                
                                <div class="flex items-center gap-3 bg-background rounded-xl py-2 px-4 text-center mih-h-48">
                                    <p
                                        class="text-text-secondary"
                                        x-text="submission.submitted_at"
                                    ></p>
                                </div>

                            </div>

                        </div>

                        <!-- Proof Image -->
                        <div>

                            <div class="flex items-center gap-2 mb-3">
                                <x-lucide-image class="w-5 h-5 text-primary"/>

                                <p class="font-semibold text-text-primary">
                                    Proof Image
                                </p>
                            </div>

                            <template x-if="submission.proof_image">

                                <img
                                    :src="'/storage/' + submission.proof_image"
                                    class="rounded-3xl
                                        w-full
                                        max-h-96
                                        object-cover
                                        border
                                        border-border"
                                >

                            </template>

                            <template x-if="!submission.proof_image">

                                <div
                                    class="rounded-2xl
                                        bg-surface
                                        py-10
                                        text-center
                                        text-text-secondary"
                                >

                                    No proof image provided.

                                </div>

                            </template>

                        </div>

                        <!-- Proof Link -->
                        <div>

                            <div class="flex items-center gap-2 mb-3">
                                <x-lucide-link class="w-5 h-5 text-primary"/>

                                <p class="font-semibold text-text-primary">
                                    Submission Link
                                </p>
                            </div>

                            <template x-if="submission.proof_link">

                                <a
                                    :href="submission.proof_link"
                                    target="_blank"
                                    class="block
                                        rounded-2xl
                                        bg-surface
                                        px-5 py-4
                                        text-primary
                                        hover:underline
                                        break-all"
                                    x-text="submission.proof_link"
                                ></a>

                            </template>

                            <template x-if="!submission.proof_link">

                                <div
                                    class="rounded-2xl
                                        bg-surface
                                        py-6
                                        text-center
                                        text-text-secondary"
                                >

                                    No submission link.

                                </div>

                            </template>

                        </div>

                        <!-- Notes -->
                        <div>

                            <div class="flex items-center gap-2 mb-3">
                                <x-lucide-notebook-pen class="w-5 h-5 text-primary"/>

                                <p class="font-semibold text-text-primary">
                                    Notes
                                </p>
                            </div>

                            <div
                                class="rounded-2xl
                                    bg-surface
                                    px-5 py-4
                                    min-h-28"
                            >

                                <p
                                    class="leading-7 whitespace-pre-line text-text-secondary"
                                    x-text="submission.notes || 'No notes provided.'"
                                ></p>

                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div
                        class="border-t-2 border-border
                            px-6 py-5 font-montserrat
                            flex justify-end gap-3"
                    >
                        <template x-if="reviewMode">
                            <div class="flex gap-3">
                                <button
                                    @click="rejectSubmission()"
                                    class="px-6 py-2
                                        rounded-2xl
                                        bg-red-accent
                                        hover:bg-red-700
                                        text-white
                                        transition
                                        font-montserrat
                                        cursor-pointer"
                                >
                                    Reject
                                </button>
                                <button
                                    @click="approveSubmission()"
                                    class="px-6 py-2
                                        rounded-2xl
                                        bg-quartiary
                                        hover:bg-emerald-700
                                        text-white
                                        transition
                                        font-montserrat
                                        cursor-pointer"
                                >
                                    Approve
                                </button>
                            </div>
                        </template>
                        <button
                            @click="closeSubmission()"
                            class="px-6 py-2
                                rounded-2xl
                                border-2
                                border-border
                                hover:bg-surface
                                transition
                                font-montserrat
                                text-text-primary
                                cursor-pointer"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mx-8 mt-6 rounded-3xl bg-background p-8 text-center shadow-sm mb-8">
            <x-lucide-clipboard-list class="w-12 h-12 mx-auto text-text-secondary mb-4"/>

            <h2 class="font-montserrat font-semibold text-text-primary text-lg">
                No tasks available in this project
            </h2>

            <p class="font-montserrat text-sm text-text-secondary mt-2 max-w-md mx-auto">
                This project does not have any tasks yet. Create a task first to start organizing your project activities.
            </p>

        </div>
    @endif
@endsection 