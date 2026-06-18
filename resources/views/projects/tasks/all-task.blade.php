<div class="bg-background rounded-3xl p-5 shadow-sm relative">

    <div class="absolute left-5 top-6 bottom-6 w-1 rounded-full {{ $lineColor }}"></div>

    <div class="absolute right-5 top-5">
        {!! $icon !!}
    </div>

    <div class="pl-5">
        <h2 class="font-montserrat font-bold text-xl text-text-primary leading-tight">
            {{ $title }}
        </h2>
        <div class="mt-3 flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs text-white {{ $priorityColor }}">
                {{ $priority }}
            </span>

            <span class="text-sm text-text-secondary">
                Due {{ $dueDate }}
            </span>
        </div>
        <div class="mt-4 flex items-center gap-3">
            <img
                src="{{ $avatar }}"
                class="w-8 h-8 rounded-full object-cover"
            >
            <span class="font-montserrat text-sm text-text-primary">
                {{ $assignee }}
            </span>
        </div>
        @if($image)
            <img
                src="{{ $image }}"
                class="mt-4 rounded-xl w-full h-32 object-cover"
            >
        @endif
        <button @click="showTaskModal = true" class="mt-4 w-full border rounded-full py-2 font-semibold hover:bg-surface transition">
            VIEW
            <x-lucide-eye class="inline w-4 h-4" />
        </button>

    </div>
</div>