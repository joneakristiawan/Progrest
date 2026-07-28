<div class="bg-background rounded-3xl p-5 shadow-sm relative pl-9 w-full flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all">

    @php
        $priorityLower = strtolower($task->priority);

        $accentClass = match($priorityLower) {
            'high' => 'bg-red-accent',
            'medium' => 'bg-yellow-accent',
            'low' => 'bg-quartiary'
        };
    @endphp

    {{-- Floating Left Accent Line --}}
    <div class="absolute left-4 top-6 bottom-7 w-1 rounded-full {{ $accentClass }}"></div>

    {{-- HEADER ROW --}}
    <div class="flex justify-between items-center mb-3 shrink-0">
        
        {{-- Top Left: Priority --}}
        <div class="{{ $accentClass }} px-3 py-1 rounded-lg flex items-center justify-center shadow-2xs">
            <span class="font-montserrat text-white text-[12px] font-semibold uppercase tracking-wider leading-none">
                {{ $task->priority }}
            </span>
        </div>

        {{-- Top Right: Status --}}
        @if ($task->status === 'in_progress')
            <div class="text-pastel-yellow-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-yellow-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-[12px] font-semibold leading-none">{{ __('main.task.in-progress') }}</span>
                </div>
                <x-lucide-clock class="w-6 h-6" />
            </div>
        @elseif ($task->status === 'pending')
            <div class="text-pastel-blue-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-blue-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-[12px] font-semibold leading-none">{{ __('main.task.pending') }}</span>
                </div>
                <x-lucide-hourglass class="w-6 h-6" />
            </div>
        @elseif ($task->status === 'completed')
            <div class="text-pastel-green-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-green-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-[12px] font-semibold leading-none">{{ __('main.task.completed') }}</span>
                </div>
                <x-lucide-circle-check-big class="w-6 h-6" />
            </div>
        @else
            <div class="text-pastel-red-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-red-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-[12px] font-semibold leading-none">{{ __('main.task.cancelled') }}</span>
                </div>
                <x-lucide-circle-x class="w-6 h-6" />
            </div>
        @endif

    </div>

    {{-- TITLE --}}
    <div class="pr-2 flex flex-col">
        <h2 class="text-text-primary text-xl font-semibold font-montserrat leading-snug">
            {{ $task->title }}
        </h2>
    </div>

    {{-- IMAGE PREVIEW --}}
    <div class="my-3 shrink-0">
        <img
            src="{{ str_starts_with($task->image, '/images/')
                ? $task->image
                : asset('/storage/'.$task->image) }}"
            class="rounded-2xl w-full h-32 object-cover shadow-2xs"
        >
    </div>

    {{-- collaborator --}}
    <div class="mb-4 shrink-0">
        <h3 class="text-text-primary font-semibold font-montserrat mb-2 text-sm">{{ __('main.task.collaborator') }}</h3>
        <div class="flex items-center">
            @if ($task->users->count() > 0)
                @foreach ($task->users->take(3) as $user)
                    <img src="{{ $user->avatar ? $user->avatar : '/images/profile.jpg' }}" class="w-8 h-8 rounded-full border-2 border-white object-cover shadow-2xs first:ml-0 -ml-2.5">
                @endforeach
                @if ($task->users->count() > 3)
                    <div class="w-8 h-8 rounded-full border-2 border-white bg-surface flex items-center justify-center text-xs font-semibold text-text-primary">+{{$task->users->count() - 3}}</div>
                @endif
            @else
                <div class="w-full h-8 rounded-xl bg-surface flex items-center justify-center text-[12px] font-montserrat italic text-text-secondary">
                    {{ __('main.task.no-collaborators-assigned') }}
                </div>
            @endif
        </div>
    </div>

    {{-- DUE DATE --}}
    <div class="flex flex-row gap-1.5 items-center mb-3">
        <x-lucide-calendar class="w-3.5 h-3.5 text-text-secondary"/> 
        @if (!is_null($task->deadline))
            <p class="font-montserrat text-text-secondary text-sm">{{ __('main.task.due') }} {{ $task->deadline->format('d M Y') }}</p>
        @else
            <p class="font-montserrat text-text-secondary text-sm">{{ __('main.task.due-not-set') }}</p>
        @endif
    </div>

    {{-- View button --}}
    <button
        @click="open({
            id: {{ $task->id }},
            title: @js($task->title),
            description: @js($task->description),
            priority: @js($task->priority),
            status: @js($task->status),
            deadline: @js(optional($task->deadline)?->format('d M Y')),
            go_collab_enabled: @js($task->go_collab_enabled),
            go_collab_description: @js($task->go_collab_description),
            go_collab_limit: @js($task->go_collab_limit),
            go_collab_reward: @js($task->go_collab_reward),
            image: @js($task->image), 
            members: @js($task->users->map(fn ($member) => [
                'id' => $member->id,
                'name' => $member->name,
                'avatar' => $member->avatar
            ])),
            collaborators: @js(
                $task->collaborators->map(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'pivot' => [
                        'status' => $user->pivot->status,
                        'reward_earned' => $user->pivot->reward_earned,
                        'joined_at' => optional($user->pivot->joined_at)?->format('d M Y'),
                        'completed_at' => optional($user->pivot->completed_at)?->format('d M Y'),
                    ],
                ])
            ),
            leader_id: {{ $project->leader->id }},
            leader_points: {{ (int) ($project->leader->points ?? 0) }}
        })"
        class="text-text-primary w-full py-1.5 border-2 border-gray-100 shadow-sm rounded-full flex items-center justify-center gap-2 font-semibold text-sm hover:bg-surface transition-colors font-montserrat shrink-0 cursor-pointer">
            {{ __('main.task.view') }}
        <x-lucide-eye class="w-4 h-4 text-text-secondary" />
    </button>

    @php
        $isLeader = auth()->id() === $project->leader_id;
        $isAssigned = $task->users->contains(auth()->id());
        $isProjectMember = $project->users->contains(auth()->id());
        $submission = $task->activeSubmission;
    @endphp

    @if($isProjectMember)
        @if ($submission)
            @if ($isLeader && $submission->status === 'pending')
                <button
                    @click="openReview({
                        id: {{ $submission->id }},
                        task_id: {{ $task->id }},
                        title: @js($task->title),
                        submitter: @js($submission->submitter->name),
                        submitted_at: @js($submission->created_at?->format('d M Y')),
                        submitter_avatar: @js($submission->submitter->avatar),
                        proof_image: @js($submission->proof_image),
                        proof_link: @js($submission->proof_link),
                        notes: @js($submission->notes),
                        status: @js($submission->status),
                    })"
                    class="text-text-primary w-full py-1.5 border-2 border-gray-100
                    shadow-sm rounded-full flex items-center justify-center gap-2
                    font-semibold text-sm bg-review-submission
                    hover:bg-review-submission/50 transition-colors
                    font-montserrat mt-3 cursor-pointer"
                >
                    Review Submission
                    <x-lucide-search-alert class="w-4 h-4"/>
                </button>
            @else
                <button
                    @click="openSubmission({
                        id: {{ $submission->id }},
                        title: @js($task->title),
                        submitter: @js($submission->submitter->name),
                        submitter_avatar: @js($submission->submitter->avatar),
                        submitted_at: @js($submission->created_at?->format('d M Y')),
                        proof_image: @js($submission->proof_image),
                        proof_link: @js($submission->proof_link),
                        notes: @js($submission->notes),
                        status: @js($submission->status),
                    })"
                    class="text-text-primary w-full py-1.5 border-2 border-gray-100
                        shadow-sm rounded-full flex items-center justify-center gap-2
                        font-semibold text-sm bg-mark-completed
                        hover:bg-mark-completed/50 transition-colors
                        font-montserrat mt-3 cursor-pointer"
                >
                    View Submission
                    <x-lucide-view class="w-4 h-4"/>
                </button>
            @endif
        @elseif($isAssigned)
            @if ($task->status !== 'cancelled')
                <button
                    @click="openComplete({
                        id: {{ $task->id }},
                        title: @js($task->title),
                        description: @js($task->description),
                        priority: @js($task->priority),
                    })"
                    class="text-text-primary w-full py-1.5 border-2 border-gray-100
                        shadow-sm rounded-full flex items-center justify-center gap-2
                        font-semibold text-sm bg-mark-completed
                        hover:bg-mark-completed/50 transition-colors
                        font-montserrat mt-3 cursor-pointer"
                >
                    Mark as Completed
                    <x-lucide-check-circle class="w-4 h-4"/>
                </button>
            @endif
        @endif
    @endif
</div>