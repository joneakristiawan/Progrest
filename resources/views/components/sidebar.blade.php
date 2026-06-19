@props(['menu'])

<aside id="sidebar"
    class="bg-background text-text-primary p-4 h-screen rounded-r-2xl shadow-r-xl flex flex-col gap-3 fixed transition-[width] duration-300 hidden md:flex z-40">

    <button id="sidebar-toggle"
        class="absolute top-4 right-5 p-2 text-text-primary rounded-lg hover:bg-tertiary w-10 rotate-0 hover:rotate-90 transition duration-300 focus:outline-none">
        ☰
    </button>

    <img id="app-logo"
        src="{{ asset('images/progrest_logo_green.png') }}"
        class="w-30 h-auto mt-2 transition-all duration-300">

    <img id="app-logo-p"
        src="{{ asset('images/progrest_p_logo_green.png') }}"
        class="hidden w-9 h-auto mt-13 mx-auto transition-all duration-300">

    <div class="w-full h-px bg-border rounded-xl"></div>

    <div class="sidebar-profile flex gap-3 border-[1.5px] p-2 border-border rounded-xl shadow-sm items-center bg-background">
        <div class="w-12 h-12 aspect-square flex-shrink-0 rounded-full border border-border">
            <img src="{{ asset('images/profile.jpg') }}" class="w-full h-full rounded-full sidebar-icon object-cover">
        </div>
        <div class="flex flex-col justify-center sidebar-text">
            <p class="font-montserrat font-bold text-text-primary text-sm">
                @auth {{ auth()->user()->username }} @else Username @endauth
            </p>
            <p class="font-montserrat -mt-px text-xs text-text-secondary">
                @auth {{ auth()->user()->name }} @else Reeders Rere @endauth
            </p>
        </div>
    </div>

    <p class="pt-3 font-montserrat text-xs uppercase tracking-wide font-semibold text-text-secondary opacity-80 sidebar-text">
        Menu
    </p>

    @foreach ($menu as $group)
        @foreach ($group['navigations'] as $item)
            @php $isActive = request()->is(ltrim($item['path'], '/')); @endphp 

            <a href="{{ $item['path'] }}"
               class="sidebar-item group w-full h-10 
               {{ $isActive ? 'bg-tertiary shadow-sm ring-1 ring-border' : 'bg-background hover:bg-tertiary' }} 
               transition duration-300 rounded-xl flex items-center gap-2 justify-start px-2">

                <div class="h-full w-2 -ml-2.25 
                    {{ $isActive ? 'bg-primary opacity-100' : 'opacity-0 group-hover:opacity-100' }} 
                    transition duration-300 rounded-l-xl sidebar-indicator">
                </div>

                <div class="sidebar-icon p-1.5 rounded-md flex items-center justify-center transition-colors
                    {{ $isActive ? 'bg-secondary text-primary' : 'bg-surface text-text-secondary group-hover:bg-secondary group-hover:text-primary' }}">
                    
                    @if ($loop->first)
                        <x-lucide-layout-dashboard class="w-4 h-4" />
                    @elseif ($loop->index == 1)
                        <x-lucide-folder-git-2 class="w-4 h-4" />
                    @elseif ($loop->index == 2)
                        <x-lucide-users class="w-4 h-4" />
                    @else
                        <x-lucide-user-pen class="w-4 h-4" />
                    @endif 

                </div>

                <span class="sidebar-text block py-2 font-montserrat font-semibold text-sm transition-colors
                    {{ $isActive ? 'text-primary' : 'text-text-primary group-hover:text-primary' }}">
                    {{ $item['name'] }}
                </span>
            </a>
        @endforeach
    @endforeach

    <p class="pt-3 font-montserrat text-xs uppercase tracking-wide font-semibold text-text-secondary opacity-80 sidebar-theme-title transition-all duration-300">
        Theme
    </p>

    <div class="sidebar-theme w-full rounded-xl bg-background border-[1.5px] p-3 border-border flex flex-col gap-3 items-center">

        <div class="sidebar-text flex gap-3 items-center w-full justify-center">
            <x-lucide-palette class="w-5 h-5 text-primary"/>
            <div class="flex flex-col">
                <p class="font-montserrat text-sm font-semibold text-text-primary">Select Theme</p>
                <p class="font-montserrat text-[10px] text-text-secondary">Pick your desired theme</p>
            </div>
        </div>

        <div class="sidebar-expanded-theme flex flex-row gap-2">
            <button class="theme-btn flex flex-col items-center gap-2 p-2 rounded-lg hover:bg-tertiary transition focus:outline-none" data-theme="light">
                <x-lucide-sun class="w-6 h-6 text-text-secondary" />
                <span class="font-montserrat text-sm text-text-secondary">Light</span>
            </button>

            <button class="theme-btn flex flex-col items-center gap-2 p-2 rounded-lg hover:bg-tertiary transition focus:outline-none" data-theme="dark">
                <x-lucide-moon class="w-6 h-6 text-text-secondary" />
                <span class="font-montserrat text-sm text-text-secondary">Dark</span>
            </button>

            <button class="theme-btn flex flex-col items-center gap-2 p-2 rounded-lg hover:bg-tertiary transition focus:outline-none" data-theme="system">
                <x-lucide-monitor class="w-6 h-6 text-text-secondary" />
                <span class="font-montserrat text-sm text-text-secondary">System</span>
            </button>
        </div>

        <button id="sidebar-theme-cycle" class="sidebar-collapsed-theme hidden flex-col items-center justify-center gap-1 w-full rounded-lg hover:bg-tertiary p-2 transition focus:outline-none">
            <x-lucide-sun id="sidebar-cycle-light" class="w-6 h-6 text-primary" />
            <x-lucide-moon id="sidebar-cycle-dark" class="w-6 h-6 text-primary hidden" />
            <x-lucide-monitor id="sidebar-cycle-system" class="w-6 h-6 text-primary hidden" />
            <span id="sidebar-cycle-text" class="font-montserrat text-[10px] font-bold text-primary capitalize">Light</span>
        </button>
    </div>

    <div class="mt-auto pt-3">
    <form action="{{ url('/logout') }}" method="POST">
        @csrf

        <button
            type="submit"
            class="sidebar-item group w-full h-10 bg-background border border-red-200 hover:bg-red-50 transition duration-300 rounded-xl flex items-center gap-2 px-2">

            <div
                class="h-full w-2 -ml-2.25 opacity-0 group-hover:opacity-100 bg-red-500 rounded-l-xl transition duration-300">
            </div>

            <div
                class="sidebar-icon p-1.5 rounded-md flex items-center justify-center bg-red-50 text-red-500 group-hover:bg-red-100 transition-colors">
                <x-lucide-log-out class="w-4 h-4" />
            </div>

            <span class="sidebar-text font-montserrat font-semibold text-sm text-red-500">
                Log Out
            </span>

        </button>
    </form>
</div>
</aside>

@once
<style>
    /* --- PERBAIKAN PROFIL SAAT COLLAPSE --- */
    .sidebar-collapsed .sidebar-profile {
        border: none !important; 
        padding: 0 !important; 
        box-shadow: none !important; 
        background-color: transparent !important; 
    }
    
    .sidebar-collapsed .sidebar-profile > div:first-child {
        margin-left: auto;
        margin-right: auto;
    }

    /* --- PERBAIKAN TEMA SAAT COLLAPSE --- */
    .sidebar-collapsed .sidebar-theme-title {
        display: none !important; /* Hilangkan teks Theme */
    }
    
    .sidebar-collapsed .sidebar-theme {
        margin-top: -0.25rem !important; /* Tarik paksa ke atas untuk merapatkan gap */
        padding: 0 !important; /* Hilangkan padding kontainer agar tidak renggang */
        border: none !important; 
        background-color: transparent !important; 
        box-shadow: none !important; 
    }
    
    .sidebar-collapsed .sidebar-theme > .sidebar-text {
        display: none !important; 
    }
    
    .sidebar-collapsed .sidebar-expanded-theme {
        display: none !important;
    }
    
    .sidebar-collapsed .sidebar-collapsed-theme {
        display: flex !important;
        border: 1.5px solid var(--color-border); /* Border hanya muncul di tombol siklus */
        width: 100%;
        margin-top: 0.25rem; /* Jarak halus agar sama dengan jarak antar menu */
    }
</style>
@endonce