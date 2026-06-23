<div class="bg-background rounded-3xl p-5 shadow-sm relative pl-9 w-full flex flex-col h-full hover:shadow-md hover:-translate-y-0.5 transition-all">

    @php
        $priorityLower = strtolower($priority);

        $accentClass = match($priorityLower) {
            'high' => 'bg-red-500',
            'medium' => 'bg-yellow-500',
            'low' => 'bg-quartiary'
        };

        $isCompleted = isset($progress) ? ($progress >= 100) : (strtolower($status ?? '') === 'completed');
    @endphp

    {{-- Floating Left Accent Line --}}
    <div class="absolute left-4 top-6 bottom-20 w-1 rounded-full {{ $accentClass }}"></div>

    {{-- HEADER ROW --}}
    <div class="flex justify-between items-center mb-3 shrink-0">
        
        {{-- Top Left: Priority --}}
        <div class="{{ $accentClass }} px-3 py-1 rounded-lg flex items-center justify-center shadow-2xs">
            <span class="font-montserrat text-white text-[12px] font-semibold uppercase tracking-wider leading-none">
                {{ $priority }}
            </span>
        </div>

        {{-- Top Right: Status --}}
        @if (!$isCompleted)
            <div class="text-pastel-yellow-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-yellow-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-pastel-yellow-text text-[12px] font-semibold leading-none">In Progress</span>
                </div>
                <x-lucide-clock class="w-6 h-6" />
            </div>
        @else
            <div class="text-pastel-green-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-green-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-pastel-green-text text-[12px] font-semibold leading-none">Completed</span>
                </div>
                <x-lucide-circle-check-big class="w-6 h-6" />
            </div>
        @endif

    </div>

    {{-- TITLE --}}
    <div class="pr-2 flex flex-col flex-grow">
        <h2 class="text-text-primary text-xl font-semibold font-montserrat leading-snug">
            {{ $title }}
        </h2>
    </div>

    {{-- IMAGE PREVIEW --}}
    <div class="my-3 shrink-0">
        @if($image)
            <img
                src="{{ $image }}"
                class="rounded-2xl w-full h-32 object-cover shadow-2xs"
            >
        @else
            <div class="h-32 rounded-2xl bg-surface/50 border border-gray-100 flex items-center justify-center text-text-secondary font-montserrat text-xs">
                No preview attached
            </div>
        @endif
    </div>

    {{-- collaborator --}}
    <div class="mb-4 shrink-0">
        <h3 class="text-text-primary font-semibold font-montserrat mb-2 text-sm">Collaborator</h3>
        <div class="flex items-center gap-2.5">
            <img src="{{ $avatar }}" alt="{{ $collaborator }}" class="w-8 h-8 rounded-full border-2 border-white object-cover shadow-2xs">
            <span class="font-montserrat text-sm font-medium text-text-primary">{{ $collaborator }}</span>
        </div>
    </div>

    {{-- DUE DATE & COMMENTS ROW --}}
    <div class="flex flex-row items-center justify-between mb-3 shrink-0">
        <div class="flex flex-row gap-1.5 items-center">
            <x-lucide-calendar class="w-3.5 h-3.5 text-text-secondary"/> 
            <p class="font-montserrat text-text-secondary text-sm">Due {{ $dueDate }}</p>
        </div>

        {{-- Added Comment Counter --}}
        <div class="flex flex-row gap-1.5 items-center">
            <x-lucide-message-circle class="w-3.5 h-3.5 text-text-secondary"/> 
            <p class="font-montserrat text-text-secondary text-sm">{{ $commentsCount ?? 0 }}</p>
        </div>
    </div>

    {{-- ACTION BUTTON --}}
    <button
        @click="showTaskModal = true"
        class="text-text-primary w-full py-1.5 border-2 border-gray-100 shadow-sm rounded-full flex items-center justify-center gap-2 font-semibold text-sm hover:bg-surface transition-colors font-montserrat shrink-0 cursor-pointer"
    >
        View <x-lucide-eye class="w-4 h-4 text-text-secondary" />
    </button>

</div>