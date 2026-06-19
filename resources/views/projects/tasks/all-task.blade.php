<div class="relative bg-background rounded-3xl p-5 shadow-sm min-h-[320px] flex flex-col overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">

    @php
    $lineColor = match(strtolower($priority)) {
        'high' => 'bg-red-500',
        'medium' => 'bg-yellow-400',
        'low' => 'bg-indigo-500',
        default => 'bg-green-500',
    };

    $priorityColor = match(strtolower($priority)) {
        'high' => 'bg-red-500',
        'medium' => 'bg-yellow-400 text-black',
        'low' => 'bg-indigo-500',
        default => 'bg-green-500',
    };
    @endphp

    {{-- Priority Line --}}
    <div class="absolute left-0 top-4 bottom-4 w-1 rounded-r-full {{ $lineColor }}"></div>

    {{-- Icon --}}
    <div class="absolute right-5 top-5">
        {!! $icon !!}
    </div>

    {{-- Content --}}
    <div class="pl-4 flex flex-col h-full">

        {{-- Title --}}
        <h2 class="font-montserrat font-bold text-xl text-text-primary leading-tight pr-8">
            {{ $title }}
        </h2>

        {{-- Priority --}}
        <div class="mt-3 flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs text-white {{ $priorityColor }}">
                {{ $priority }}
            </span>

            <span class="text-sm text-text-secondary">
                Due {{ $dueDate }}
            </span>
        </div>

        {{-- Assignee --}}
        <div class="mt-4 flex items-center gap-3">
            <img
                src="{{ $avatar }}"
                class="w-8 h-8 rounded-full object-cover"
            >

            <span class="font-montserrat text-sm text-text-primary">
                {{ $assignee }}
            </span>
        </div>

        {{-- Preview --}}
        <div class="mt-4">
            @if($image)
                <img
                    src="{{ $image }}"
                    class="rounded-xl w-full h-32 object-cover"
                >
            @else
                <div class="h-32 rounded-xl bg-surface"></div>
            @endif
        </div>

        {{-- Button --}}
        <button
            @click="showTaskModal = true"
            class="mt-4 w-full border border-white/30 text-white rounded-full py-2 font-semibold hover:bg-white hover:text-black transition-all duration-300"
        >
            VIEW
            <x-lucide-eye class="inline w-4 h-4" />
        </button>

    </div>

</div>