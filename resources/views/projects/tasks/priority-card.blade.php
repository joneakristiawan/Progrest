<div class="bg-background rounded-3xl p-5 shadow-sm relative w-full max-w-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
    <div class="absolute left-5 top-6 bottom-6 w-1 rounded-full {{ $status === 'OVERDUE' ? 'bg-red-500' : 'bg-yellow-500' }}"></div>

    <div class="absolute right-5 top-5">
        @if($status === 'OVERDUE')
            <x-lucide-circle-alert class="w-5 h-5 text-red-500 stroke-[2px]" />
        @else
            <x-lucide-circle-alert class="w-5 h-5 text-yellow-500 stroke-[2px]" />
        @endif
    </div>

    <div class="pl-5 flex flex-col min-w-0">
        <div class="mb-2 pr-6">
            @if($status === 'OVERDUE')
                <span class="font-montserrat font-medium text-red-500 uppercase text-sm">
                    {{ $status }}
                </span>
            @else
                <span class="font-montserrat font-medium text-yellow-500 uppercase text-sm">
                    {{ $status }}
                </span>
            @endif
        </div>

        <h2 class="text-text-primary text-lg font-semibold font-montserrat leading-snug mb-3 pr-2 truncate">
            {{ $title }}
        </h2>

        <div class="flex items-center justify-between mt-1">
            <div class="flex flex-row gap-1.5 items-center">
                <x-lucide-calendar class="w-3.5 h-3.5 text-text-secondary"/> 
                <p class="font-montserrat text-text-secondary text-sm">Due {{ $dueDate }}</p>
            </div>
            <p class="font-montserrat text-xs font-bold whitespace-nowrap ml-2 {{ $status === 'OVERDUE' ? 'text-red-500' : ($status === 'DUE SOON' ? 'text-yellow-500' : 'text-pastel-green-text') }}">
                @if($daysLeft < 0)
                    {{ abs($daysLeft) }} days late
                @elseif($daysLeft == 0)
                    Due Today
                @else
                    {{ $daysLeft }} days left
                @endif
            </p>
        </div>
    </div>
</div>