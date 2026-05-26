@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    $statistics = [
        'login_streak' => ['current' => 5, 'best' => 8],
        'projects_completed' => 4,
        'points' => ['current' => 7, 'highest' => 11],
        'collabs_completed' => 6,
    ];

    $taskReminders = [
        [
            'title' => 'Set the Whole Concept',
            'project_name' => 'AquaVerse',
            'status' => 'Overdue (+2 days)',
            'due_date' => '08/04/26',
            'type' => 'critical',
            'image' => null,
        ],
        [
            'title' => 'User Interface Design',
            'project_name' => 'Mindspace',
            'status' => 'Overdue (+2 days)',
            'due_date' => '08/04/26',
            'type' => 'critical',
            'image' => 'placeholder', 
        ],
        [
            'title' => 'Code Login & Discover Page',
            'project_name' => 'TravelMate',
            'status' => 'Overdue (+1 days)',
            'due_date' => '07/04/26',
            'type' => 'critical',
            'image' => 'placeholder',
        ],
        [
            'title' => 'Create the Tagline',
            'project_name' => 'EcoTrack',
            'status' => 'Overdue (+1 days)',
            'due_date' => '07/04/26',
            'type' => 'critical',
            'image' => null,
        ],
        [
            'title' => 'Review User Testing',
            'project_name' => 'PetPal',
            'status' => 'Due Soon (Today)',
            'due_date' => '06/04/26',
            'type' => 'warning',
            'image' => null,
        ],
        [
            'title' => 'Fix Recipe Page Bug',
            'project_name' => 'CookEase',
            'status' => 'Due Soon (Today)',
            'due_date' => '06/04/26',
            'type' => 'warning',
            'image' => 'placeholder',
        ],
    ];
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<div class="p-4 md:p-8 pt-6 max-w-7xl mx-auto">
    
    <div id="dashboard-header" class="bg-background rounded-[2rem] p-4 px-6 mb-8 shadow-sm border-[1.5px] border-border flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile" class="w-14 h-14 rounded-full object-cover shadow-sm border-[3px] border-border">
            <div>
                <h1 class="font-montserrat text-2xl font-bold text-text-primary">
                    Welcome Back, <span class="text-primary">@auth {{ auth()->user()->username }} @else Collab1 @endauth</span>
                </h1>
                <p class="font-montserrat text-sm text-text-secondary mt-0.5">Start making progress and collab</p>
            </div>
        </div>
        
        <div class="relative">
            <button id="notif-btn" class="p-3 bg-background shadow-sm rounded-full border border-border hover:bg-surface transition-colors focus:outline-none">
                <x-lucide-bell class="w-6 h-6 text-text-primary" />
            </button>
            <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-72 bg-background border border-border shadow-lg rounded-2xl p-5 z-50 font-montserrat">
                <div class="flex justify-between items-center mb-3 border-b border-border pb-2">
                    <p class="font-bold text-[15px] text-text-primary">Notifications</p>
                    <span class="text-[10px] bg-primary text-white px-2 py-0.5 rounded-full">0 New</span>
                </div>
                <p class="text-xs text-text-secondary text-center py-4">You have no new notifications.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        
        <div class="lg:col-span-2 flex flex-col gap-8">
            
            <div id="dashboard-stats" class="bg-primary rounded-[2rem] p-5 shadow-md">
                <div class="flex items-center justify-between text-white mb-5 px-3">
                    <div class="flex gap-4">
                        <button id="share-btn" class="focus:outline-none hover:opacity-70 transition-opacity" title="Download Statistics">
                            <x-lucide-share-2 class="w-5 h-5" />
                        </button>
                    </div>
                    <span class="font-montserrat font-bold text-lg">Account Statistics</span>
                    <div class="w-14"></div>
                </div>
                
                <div class="bg-background rounded-2xl p-6 grid grid-cols-2 md:grid-cols-4 gap-4 divide-y md:divide-y-0 md:divide-x divide-border shadow-inner">
                    <div class="flex flex-col items-center justify-center">
                        <div class="flex items-center gap-1.5 text-primary font-parkinsans font-bold text-4xl">
                            <x-lucide-zap class="w-7 h-7 fill-current" /> {{ $statistics['login_streak']['current'] }}
                        </div>
                        <p class="font-montserrat font-bold text-text-primary text-sm mt-2">Login Streak</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5"><span class="font-bold text-text-primary">{{ $statistics['login_streak']['best'] }}</span> Best</p>
                    </div>
                    <div class="flex flex-col items-center justify-center pt-4 md:pt-0">
                        <div class="flex items-center gap-2 text-primary font-parkinsans font-bold text-4xl">
                            <x-lucide-file-text class="w-7 h-7" /> {{ $statistics['projects_completed'] }}
                        </div>
                        <p class="font-montserrat font-bold text-text-primary text-sm mt-2">Projects</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5">Completed</p>
                    </div>
                    <div class="flex flex-col items-center justify-center pt-4 md:pt-0">
                        <div class="flex items-center gap-2 text-primary font-parkinsans font-bold text-4xl">
                            <x-lucide-users class="w-7 h-7" /> {{ $statistics['collabs_completed'] }}
                        </div>
                        <p class="font-montserrat font-bold text-text-primary text-sm mt-2">Collabs</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5">Completed</p>
                    </div>
                    <div class="flex flex-col items-center justify-center pt-4 md:pt-0">
                        <div class="flex items-center gap-1.5 text-primary font-parkinsans font-bold text-4xl">
                            <span class="bg-primary text-white rounded-full w-7 h-7 flex items-center justify-center text-base">P</span> {{ $statistics['points']['current'] }}
                        </div>
                        <p class="font-montserrat font-bold text-text-primary text-sm mt-2">Points</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5"><span class="font-bold text-text-primary">{{ $statistics['points']['highest'] }}</span> Highest</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <h2 class="font-montserrat text-xl font-bold text-text-primary mb-4">Your Monthly Task Contribution</h2>
                <div class="bg-background rounded-3xl p-6 shadow-sm border-[1.5px] border-border flex flex-col justify-between">
                    <div class="flex justify-end gap-3 mb-6" id="chart-tabs">
                        <button class="chart-tab bg-surface border border-border text-text-primary text-xs font-montserrat font-bold px-4 py-1.5 rounded-full transition-colors focus:outline-none">Weekly</button>
                        <button class="chart-tab active bg-border shadow-sm text-text-primary text-xs font-montserrat font-bold px-4 py-1.5 rounded-full transition-colors focus:outline-none">Monthly</button>
                        <button class="chart-tab bg-surface border border-border text-text-primary text-xs font-montserrat font-bold px-4 py-1.5 rounded-full transition-colors focus:outline-none">Annually</button>
                    </div>
                    
                    <div class="flex h-56 md:h-64">
                        <div class="flex flex-col justify-between text-[10px] font-montserrat font-medium text-text-secondary py-1 pr-4 text-right">
                            <span>250</span><span>200</span><span>150</span><span>100</span><span>50</span><span>0</span>
                        </div>
                        <div class="w-full h-full bg-surface rounded-xl border border-border relative overflow-hidden flex-1">
                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polygon id="chart-polygon" points="0,100 0,60 20,70 40,55 60,85 80,40 100,60 100,100" fill="var(--color-primary)" opacity="0.1" class="transition-all duration-500" />
                                <polyline id="chart-polyline" points="0,60 20,70 40,55 60,85 80,40 100,60" fill="none" stroke="var(--color-primary-hover)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-all duration-500" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-3 text-xs font-montserrat font-medium text-text-secondary pl-10 pr-2">
                        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 flex flex-col h-full">
            <h2 class="font-montserrat text-xl font-bold text-text-primary mb-6">Current Projects</h2>
            <div class="flex flex-col gap-5">
                
                @forelse ($projects->take(3) as $proj)
                    <a href="/projects" class="block bg-background rounded-[1.25rem] p-5 shadow-sm border-[1.5px] border-border relative overflow-hidden group hover:shadow-md hover:-translate-y-0.5 transition-all">
                        <div class="absolute left-0 top-0 bottom-0 w-2" style="background-color: {{ $proj->accent ?? '#14452F' }}"></div>
                        
                        <div class="pl-2">
                            <h3 class="font-parkinsans font-bold text-text-primary text-lg group-hover:text-primary transition-colors">{{ $proj->title }}</h3>
                            <p class="font-montserrat text-xs text-text-secondary mt-1.5 line-clamp-2 leading-relaxed">{{ $proj->description }}</p>
                            
                            <div class="mt-5 flex items-center justify-between text-[11px] font-montserrat font-bold text-text-primary mb-2">
                                <span>Progress:</span>
                                <span>{{ $proj->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-border h-2 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000" style="width: {{ $proj->progress ?? 0 }}%; background-color: {{ $proj->accent ?? '#14452F' }}"></div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="bg-surface rounded-2xl p-5 text-center border-[1.5px] border-border">
                        <p class="font-montserrat text-sm text-text-secondary">No active projects yet.</p>
                    </div>
                @endforelse

                <a href="/projects" class="mt-2 w-full bg-primary hover:bg-primary-hover text-white py-3.5 rounded-full flex items-center justify-center gap-2 font-montserrat font-bold text-[13px] transition-colors shadow-md">
                    <x-lucide-eye class="w-5 h-5" /> All Projects
                </a>
            </div>
        </div>
    </div>

    <div class="w-full">
        <div class="flex items-center gap-2 mb-2">
            <h2 class="font-montserrat text-xl font-bold text-text-primary">Task Reminders</h2>
        </div>
        <div class="flex items-center gap-2 mb-6">
            <div class="w-2.5 h-2.5 bg-primary rounded-full"></div>
            <span class="font-montserrat text-[13px] text-text-secondary">Keep your project on plan</span>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
            @foreach ($taskReminders as $task)
                <a href="/projects" class="block bg-background rounded-3xl p-5 shadow-sm border-[1.5px] border-border relative overflow-hidden transition-all hover:-translate-y-1 hover:shadow-md break-inside-avoid group">
                    <div class="absolute left-0 top-0 bottom-0 w-2 {{ $task['type'] == 'critical' ? 'bg-red-500' : 'bg-yellow-500' }}"></div>
                    <div class="pl-3">
                        <div class="flex justify-between items-start mb-3">
                            <span class="font-montserrat font-bold text-sm {{ $task['type'] == 'critical' ? 'text-red-500' : 'text-text-primary' }}">
                                {{ $task['status'] }}
                            </span>
                            @if($task['type'] == 'critical') 
                                <x-lucide-alert-circle class="w-4 h-4 text-red-500" /> 
                            @else 
                                <x-lucide-info class="w-4 h-4 text-yellow-500" /> 
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                            <span class="text-[11px] font-montserrat text-text-secondary">Project: {{ $task['project_name'] }}</span>
                        </div>

                        @if($task['image'])
                            <div class="w-full h-36 bg-surface rounded-xl mb-4 border border-border overflow-hidden"></div>
                        @endif

                        <h3 class="font-parkinsans font-bold text-text-primary text-[17px] leading-tight mb-4 group-hover:text-primary transition-colors">{{ $task['title'] }}</h3>
                        <p class="text-[11px] font-montserrat font-medium text-text-secondary opacity-80">Due {{ $task['due_date'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

</div>

<!-- <x-footer /> -->

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Logika Dropdown Notifikasi
    const notifBtn = document.getElementById('notif-btn');
    const notifDropdown = document.getElementById('notif-dropdown');
    
    notifBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
    });
    
    document.addEventListener('click', (e) => {
        if (notifBtn && notifDropdown && !notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.classList.add('hidden');
        }
    });

    // 2. Logika Tab Grafik
    const chartTabs = document.querySelectorAll('.chart-tab');
    const chartPolygon = document.getElementById('chart-polygon');
    const chartPolyline = document.getElementById('chart-polyline');

    chartTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            chartTabs.forEach(t => {
                t.classList.remove('bg-border', 'shadow-sm', 'active');
                t.classList.add('bg-surface', 'border', 'border-border');
            });

            tab.classList.remove('bg-surface', 'border', 'border-border');
            tab.classList.add('bg-border', 'shadow-sm', 'active');

            const p1 = Math.floor(Math.random() * 40) + 20;
            const p2 = Math.floor(Math.random() * 40) + 40;
            const p3 = Math.floor(Math.random() * 40) + 20;
            const p4 = Math.floor(Math.random() * 40) + 60;
            const p5 = Math.floor(Math.random() * 40) + 30;
            const p6 = Math.floor(Math.random() * 40) + 40;
            
            const pointString = `0,${p1} 20,${p2} 40,${p3} 60,${p4} 80,${p5} 100,${p6}`;
            
            chartPolygon.setAttribute('points', `0,100 ${pointString} 100,100`);
            chartPolyline.setAttribute('points', pointString);
        });
    });

    // 3. Logika Share Statistics
    const shareBtn = document.getElementById('share-btn');

    shareBtn?.addEventListener('click', () => {
        document.body.style.cursor = 'wait';
        
        const exportDiv = document.createElement('div');
        exportDiv.style.position = 'absolute';
        exportDiv.style.left = '-9999px';
        exportDiv.style.top = '-9999px';
        exportDiv.style.width = '800px'; 
        exportDiv.style.padding = '32px';
        exportDiv.style.backgroundColor = getComputedStyle(document.body).getPropertyValue('--color-background') || '#FFFFFF'; 
        
        const headerClone = document.getElementById('dashboard-header').cloneNode(true);
        const statsClone = document.getElementById('dashboard-stats').cloneNode(true);
        
        headerClone.querySelector('button')?.remove();
        headerClone.querySelector('.relative')?.remove();
        
        exportDiv.appendChild(headerClone);
        
        const spacer = document.createElement('div');
        spacer.style.height = '24px';
        exportDiv.appendChild(spacer);
        
        exportDiv.appendChild(statsClone);
        document.body.appendChild(exportDiv);

        html2canvas(exportDiv, { backgroundColor: null, scale: 2 }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Progrest_Statistics.jpg';
            link.href = canvas.toDataURL('image/jpeg', 1.0);
            link.click();
            
            document.body.removeChild(exportDiv);
            document.body.style.cursor = 'default';
        }).catch(err => {
            console.error("Gagal mendownload gambar:", err);
            document.body.style.cursor = 'default';
        });
    });
});
</script>
@endsection