@props(['menu'])

<nav class="md:hidden relative bg-background border-b border-border shadow-sm z-50">
    <div class="flex items-center justify-between p-4">
        <button id="mobile-menu-btn" class="p-2 text-text-primary rounded-lg hover:bg-tertiary focus:outline-none rotate-0 hover:rotate-90 transition duration-300">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <img id="mobile-logo" src="images/progrest_logo_green.png" alt="Progrest" class="h-7 mt-1 w-auto transition-all duration-300">

        <div class="relative">
            <button id="mobile-profile-btn" class="focus:outline-none flex items-center">
                <img src="images/profile.jpg" alt="Profile" class="h-10 rounded-full border border-border object-cover">
            </button>

            <div id="mobile-profile-dropdown" class="hidden absolute right-0 mt-3 w-48 bg-background border border-border rounded-xl shadow-lg p-4 text-center">
                <p class="font-montserrat font-bold text-text-primary text-lg">
                    @auth {{ auth()->user()->username }} @else Guest @endauth
                </p>
                <p class="font-montserrat text-sm text-text-secondary">
                    @auth {{ auth()->user()->name }} @else Visitor @endauth
                </p>
            </div>
        </div>
    </div>

    <div id="mobile-dropdown-menu" class="hidden absolute w-full left-0 top-full bg-background border-b border-border shadow-lg flex-col px-4 py-2">

        @foreach ($menu as $group)
            @foreach ($group['navigations'] as $item)
                @php $isActive = request()->is(ltrim($item['path'], '/')); @endphp

                <a href="{{ $item['path'] }}"
                   class="flex items-center gap-3 py-3 px-2 group transition duration-300 rounded-xl relative overflow-hidden mb-1 hover:ml-1 hover:shadow-md hover:bg-surface hover:scale-[1.01]
                   {{ $isActive ? 'bg-surface shadow-sm ring-1 ring-border' : 'bg-background' }}">

                    <div class="absolute left-0 top-0 h-full w-1.5 transition duration-300
                        {{ $isActive ? 'bg-primary opacity-100' : 'opacity-0 group-hover:opacity-100 bg-primary' }}">
                    </div>

                    <div class="p-1.5 rounded-md transition-colors ml-2
                        {{ $isActive ? 'bg-background shadow-sm text-primary border border-border' : 'bg-surface text-text-secondary group-hover:bg-background group-hover:text-primary group-hover:border group-hover:border-border' }}">

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

                    <span class="font-montserrat text-sm font-semibold transition-colors
                        {{ $isActive ? 'text-primary' : 'text-text-primary group-hover:text-primary' }}">
                        {{ $item['name'] }}
                    </span>
                </a>
            @endforeach
        @endforeach

        <div class="w-full h-px bg-border my-2"></div>

        <button id="mobile-theme-btn" class="w-full flex items-center justify-between py-3 px-2 focus:outline-none group hover:bg-surface transition rounded-xl">
            <div class="flex items-center gap-3">
                <div class="p-1.5 rounded-md bg-surface group-hover:bg-background group-hover:border group-hover:border-border transition-colors">
                    <x-lucide-palette class="w-4 h-4 text-text-secondary group-hover:text-primary transition-colors" />
                </div>
                <span class="font-montserrat text-sm font-semibold text-text-primary group-hover:text-primary transition-colors">
                    Themes
                </span>
            </div>

            <div class="p-2 bg-surface group-hover:bg-background rounded-lg text-text-primary group-hover:text-primary transition-colors flex items-center gap-2 border border-border">
                <span id="mobile-theme-text" class="font-montserrat text-xs font-bold capitalize">Light</span>
                <x-lucide-sun id="mobile-icon-light" class="w-4 h-4" />
                <x-lucide-moon id="mobile-icon-dark" class="w-4 h-4 hidden" />
                <x-lucide-monitor id="mobile-icon-system" class="w-4 h-4 hidden" />
            </div>
        </button>

        <div class="w-full h-px bg-border my-2"></div>

        <form action="{{ url('/logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="w-full flex items-center gap-3 py-3 px-2 group transition duration-300 rounded-xl relative overflow-hidden mb-1 bg-background hover:bg-surface hover:shadow-md">

                <div class="absolute left-0 top-0 h-full w-1.5 bg-red-500 opacity-0 group-hover:opacity-100 transition duration-300"></div>

                <div class="p-1.5 rounded-md flex items-center justify-center transition-colors ml-2 bg-surface text-red-500 group-hover:bg-red-100 group-hover:text-red-600 border border-border">
                    <x-lucide-log-out class="w-4 h-4" />
                </div>

                <span class="font-montserrat text-sm font-semibold text-red-500 group-hover:text-red-600">
                    Log Out
                </span>

            </button>
        </form>

    </div>
</nav>