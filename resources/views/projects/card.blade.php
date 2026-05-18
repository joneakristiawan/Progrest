<div class="project-container bg-background rounded-3xl p-5 shadow-sm relative pl-9 w-full flex flex-col h-full">
    <div class="project-line absolute left-4 top-6 bottom-24 w-1 rounded-full" style="background-color: {{ $accentColor ?? 'bg-primary' }};"></div>

    <div class="flex justify-between items-start mb-4 shrink-0">
        <div class="p-2 rounded-xl flex justify-center items-center" style="background-color: {{ $accentColor }}">
            <x-dynamic-component 
                :component="'lucide-' . ($icon ?: 'folder')"
                class="w-6 text-text-contrast" 
            />
        </div>
        @if ($progress < 100)
            <div class="text-pastel-yellow-text flex flex-row gap-4 items-center">
                <div class="bg-pastel-yellow-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-pastel-yellow-text text-[12px] font-semibold leading-none">In Progress</span>
                </div>
                <x-lucide-clock class="w-8" />
            </div>
        @else
            <div class="text-pastel-green-text flex flex-row gap-4 items-center">
                <div class="bg-pastel-green-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-pastel-green-text text-[12px] font-semibold leading-none">Completed</span>
                </div>
                <x-lucide-circle-check-big class="w-8" />
            </div>
        @endif
    </div>

    <div class="pr-2 flex flex-col flex-grow">
        <h2 class="text-text-primary text-xl font-semibold font-montserrat">{{ $title }}</h2>
        <p class="text-text-primary text-sm mt-1 leading-snug font-montserrat">{{ $description }}</p>
    </div>

    <div class="mb-4 mt-4 shrink-0">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-text-primary font-semibold font-montserrat text-sm">Progress</h3>
            <span class="text-text-primary font-semibold font-montserrat text-sm">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
            <div class="h-full rounded-full" style="width: {{ $progress }}%; background-color: {{ $accentColor }}"></div>
        </div>
    </div>

    <div class="mb-4 shrink-0">
        <h3 class="text-text-primary font-semibold font-montserrat mb-2 text-sm">Collaborators</h3>
        <div class="flex items-center -space-x-2">
            @foreach ($collaborators->take(3) as $avatar)
                <img src="images/profile.jpg" alt="Collaborator" class="w-8 h-8 rounded-full border-2 border-white object-cover relative z-0">
            @endforeach
            
            @php
                $extraCollaborators = $collaborators->count() - 3; 
            @endphp

            @if ($extraCollaborators > 0)
                <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-xs font-semibold relative z-10 shadow-sm">
                    +{{ $extraCollaborators }}
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-row items-center justify-between mb-3 shrink-0">
        <div class="flex flex-row gap-1.5 items-center">
            <x-lucide-calendar class="w-3.5 h-3.5 text-text-secondary"/> 
            <p class="font-montserrat text-text-secondary text-sm">Due in {{ $days_remaining }} days</p>
        </div>
        <div class="flex flex-row gap-1.5 items-center">
            <x-lucide-message-circle class="w-3.5 h-3.5 text-text-secondary"/> 
            <p class="font-montserrat text-text-secondary text-sm">10</p>
        </div>
    </div>

    <button class="text-text-primary w-full py-1.5 border-2 border-gray-100 shadow-sm rounded-full flex items-center justify-center gap-2 font-semibold text-sm hover:bg-surface transition-colors font-montserrat shrink-0">
        Continue <x-lucide-eye class="w-5 h-5" />
    </button>
</div>