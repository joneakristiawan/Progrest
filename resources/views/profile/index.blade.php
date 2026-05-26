@extends('layouts.app')

@section('title', 'Profile')

@section('content')

@php
    $taskHelped = [
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '+5',
            'color' => '#8B3F3F'
        ],
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '+5',
            'color' => '#B89A3D'
        ],
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '+5',
            'color' => '#2F6D92'
        ],
    ];

    $taskCreated = [
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '-8',
            'color' => '#23824F'
        ]
    ];
@endphp

<div class="p-4 md:p-8 max-w-7xl mx-auto">

    <!-- PROFILE HEADER -->
    <div class="bg-background rounded-[2rem] overflow-hidden shadow-sm border border-border mb-8">

        <!-- COVER -->
        <div class="relative h-44 md:h-52 overflow-visible">

            <!-- BACKGROUND -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="{{ asset('images/Checker_BG.png') }}" 
                    alt="Background"
                    class="w-full h-full object-cover"
                >
            </div>

            <!-- EDIT BUTTON -->
            <button class="absolute top-5 right-5 z-30 bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-full font-montserrat font-bold flex items-center gap-2 shadow-md transition-colors">
                <x-lucide-pencil class="w-4 h-4" />
                Edit
            </button>

            <!-- PROFILE IMAGE -->
            <div class="absolute left-1/2 -bottom-14 -translate-x-1/2 z-50">
                <img 
                    src="{{ asset('images/profile.jpg') }}"
                    class="w-32 h-32 rounded-full object-cover border-[7px] border-background shadow-xl"
                >
            </div>

        </div>

        <!-- PROFILE INFO -->
        <div class="pt-20 pb-6 px-8 relative z-0 bg-background">

            <!-- SLIDER -->
            <div class="absolute left-6 top-5 flex items-center gap-3">

                <div class="w-7 h-7 bg-border rounded"></div>
                <div class="w-7 h-7 bg-border rounded"></div>
                <div class="w-7 h-7 bg-border rounded"></div>

                <button>
                    <x-lucide-chevron-right class="w-5 h-5 text-text-primary" />
                </button>

                <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div>

            </div>

            <!-- POINTS -->
            <div class="absolute right-8 top-5 flex items-center gap-2">

                <span class="bg-primary text-white px-3 py-1 rounded-lg font-parkinsans font-bold text-3xl leading-none">
                    123
                </span>

                <span class="font-montserrat text-text-primary text-lg">
                    Points
                </span>

            </div>

            <!-- NAME -->
            <div class="text-center">

                <h1 class="font-parkinsans text-3xl font-bold text-text-primary">
                    Kevin Jio
                </h1>

                <p class="font-montserrat text-text-secondary text-lg">
                    @progressor
                </p>

            </div>

        </div>
    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ABOUT -->
        <div class="bg-background rounded-[2rem] p-7 shadow-sm border border-border flex flex-col justify-between">

            <div>

                <h2 class="font-parkinsans text-3xl font-bold text-text-primary mb-5">
                    About
                </h2>

                <p class="font-montserrat text-text-secondary leading-relaxed text-[15px]">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>

            </div>

            <div class="mt-12 flex flex-col gap-5">

                <div class="flex items-center gap-3 text-text-secondary">
                    <x-lucide-mail class="w-5 h-5 text-primary" />

                    <span class="font-montserrat text-sm">
                        progressor@gmail.com
                    </span>
                </div>

                <div class="flex items-center gap-3 text-text-secondary">
                    <x-lucide-building-2 class="w-5 h-5 text-primary" />

                    <span class="font-montserrat text-sm">
                        Task Progressor
                    </span>
                </div>

            </div>
        </div>

        <!-- TASK HELPED -->
        <div class="bg-background rounded-[2rem] p-6 shadow-sm border border-border">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-parkinsans text-2xl font-bold text-text-primary">
                    Task Helped
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-parkinsans font-bold text-2xl leading-none">
                    12
                </div>

            </div>

            <div class="flex flex-col gap-4">

                @foreach($taskHelped as $task)

                    <div 
                        class="rounded-[1.4rem] p-5 text-white relative overflow-hidden"
                        style="background-color: {{ $task['color'] }}"
                    >

                        <div class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center text-sm font-bold text-black">
                            {{ $task['point'] }}
                        </div>

                        <h3 class="font-parkinsans text-2xl font-bold leading-none">
                            {{ $task['project'] }}
                        </h3>

                        <p class="font-montserrat text-sm mt-2">
                            {{ $task['task'] }}
                        </p>

                        <p class="font-montserrat text-sm mt-1">
                            {{ $task['date'] }}
                        </p>

                    </div>

                @endforeach

            </div>
        </div>

        <!-- TASK CREATED -->
        <div class="bg-background rounded-[2rem] p-6 shadow-sm border border-border">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-parkinsans text-2xl font-bold text-text-primary">
                    Task Created
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-parkinsans font-bold text-2xl leading-none">
                    1
                </div>

            </div>

            <div class="flex flex-col gap-4">

                @foreach($taskCreated as $task)

                    <div 
                        class="rounded-[1.4rem] p-5 text-white relative overflow-hidden"
                        style="background-color: {{ $task['color'] }}"
                    >

                        <div class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center text-sm font-bold text-black">
                            {{ $task['point'] }}
                        </div>

                        <h3 class="font-parkinsans text-2xl font-bold leading-none">
                            {{ $task['project'] }}
                        </h3>

                        <p class="font-montserrat text-sm mt-2">
                            {{ $task['task'] }}
                        </p>

                        <p class="font-montserrat text-sm mt-1">
                            {{ $task['date'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection