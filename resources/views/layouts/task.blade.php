<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="/images/progrest_p_logo_green.png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <script>
        const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";

        if (isCollapsed) {
            document.documentElement.classList.add("sidebar-collapsed");
        }

        document.documentElement.classList.add("no-transition");
    </script>
    <style>
        #sidebar {
            width: 16rem;
            overflow: hidden;
            will-change: width; 
            z-index: 50; 
            position: fixed; 
        }
        .sidebar-collapsed .sidebar-theme {
            margin-top: 2rem; 
        }
        .sidebar-collapsed .sidebar-theme > .flex.flex-row {
            flex-direction: column;
            align-items: center;
        }
        .sidebar-collapsed #sidebar {
            width: 5rem;
        }
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
        .sidebar-collapsed .sidebar-indicator {
            display: none;
        }
        .sidebar-collapsed .sidebar-item {
            justify-content: center !important;
        }
        .sidebar-collapsed #app-logo {
            display: none;
        }
        .sidebar-collapsed #app-logo-p {
            display: block;
        }
        .no-transition * {
            transition: none !important;
        }
        #sidebarFiller{
            width: 16rem;
        }
        .sidebar-collapsed #sidebarFiller {
            width: 5rem;
        }
        /* --- TAMBAHAN UNTUK THEME COLLAPSE --- */
        .sidebar-collapsed .sidebar-theme-title {
            text-align: center;
            font-size: 0.65rem; /* Mengecilkan teks "THEMES" agar pas di tengah */
            margin-bottom: 0.2rem;
        }
        .sidebar-collapsed .sidebar-expanded-theme {
            display: none !important; /* Sembunyikan 3 tombol saat collapse */
        }
        .sidebar-collapsed .sidebar-collapsed-theme {
            display: flex !important; /* Tampilkan 1 tombol siklus saat collapse */
        }
        .date-input::-webkit-calendar-picker-indicator {
            opacity: 0;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen bg-surface">
        
        <aside class="hidden md:flex md:shrink-0">
            <x-sidebar :menu="$menu"/>
            <div id="sidebarFiller"></div>
        </aside>
        
        <div class="flex flex-col flex-1 min-w-0">
            <x-hamburger :menu="$menu"/>
            
            <main class="flex-1 relative focus:outline-none">
                @yield('content')

                @include('components.footer')
            </main>
        </div>
    </div>

    {{-- OPENED PANEL OVERLAY --}}

    <div id="overlay" class="fixed inset-0 hidden bg-black/50 z-40"></div>

    {{-- SLIDE PANEL --}}

    <div id="panel" class="fixed flex flex-col top-0 right-0 z-50 h-full w-full max-w-lg
        translate-x-full bg-background shadow-2xl
        transition-transform duration-300 p-4 rounded-l-2xl">

            {{-- Aksen Hijau I  --}}
            <div class="absolute -top-24 left-1/2
                h-64 w-86 -translate-x-1/2
                rounded-full bg-emerald-300/15
                blur-3xl">
            </div>

            <!-- Aksen Hijau II -->
            <div class="absolute top-10 right-10
                        h-40 w-66 rounded-full
                        bg-green-200/15 blur-3xl">
            </div>

            <div class="flex flex-col items-end justify-between pb-4 mb-3">
                <button onclick="closePanel()" class="text-xl font-semibold hover:rotate-90 rotate-0 transition duration-300 text-text-primary cursor-pointer">
                    ✕
                </button>
                <div class="flex gap-5 items-center w-full -mt-1">
                    <div class="flex justify-center items-center w-14 h-14 border-pastel-green-text bg-pastel-green-background border-2 p-2 rounded-2xl shadow-3xl shadow-[0_10px_30px_rgba(0,0,0,0.12)]">
                        <x-lucide-folder-plus class="w-8 text-pastel-green-text"/>
                    </div>
                    <div class="flex flex-col text-text-secondary text-sm max-w-70">
                        <p class="font-montserrat font-bold text-2xl text-text-primary">{{ __('main.task.create-new-task') }}</p>
                        <p>{{ __('main.task.create-new-task-subtitle') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto"
                x-data="createTaskForm()">
                <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="flex flex-col gap-4">
                    @csrf
                    <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border">
                        <div class="flex flex-row gap-2 items-center">
                            <div class="shadow-2xl shadow-pastel-green-background">
                                <x-lucide-folder-git-2 class="w-5 text-pastel-green-text"/>
                            </div>
                            <p class="font-montserrat font-semibold text-[14px] text-text-primary">{{ __('main.task.task-details') }}</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">{{ __('main.task.task-title') }}</p>

                            {{-- Task TITLE INPUT --}}

                            <input
                                x-model="task.title"
                                name="title"
                                type="text"
                                placeholder="{{ __('main.ph.task-title-eg') }}"
                                class="w-full rounded-lg border-[1.5px] border-text-primary/50 px-3 py-2 text-sm text-text-primary placeholder:text-placeholder"
                            >
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">{{ __('main.task.task-description') }}</p>

                            {{-- Task DESCRIPTION INPUT --}}

                            <textarea
                                x-model="task.description"
                                name="description"
                                placeholder="{{ __('main.ph.task-desc') }}"
                                class="w-full h-30 rounded-lg border-[1.5px] border-text-primary/50 px-3 py-2 text-sm text-text-primary placeholder:text-placeholder"
                            ></textarea>
                        </div>
                    </div>

                    {{-- Task Member Selection --}}

                    <div
                        class="bg-surface rounded-2xl p-4 space-y-4"
                    >
                        {{-- Header --}}
                        <div class="flex items-center gap-2">
                            <div class="shadow-2xl shadow-pastel-blue-background">
                                <x-lucide-users class="w-5 text-primary"/>
                            </div>

                            <div>
                                <p class="font-montserrat text-sm font-semibold text-text-primary">
                                    {{ __('main.task.assigned-members') }}
                                </p>

                                <p class="text-xs text-text-secondary font-montserrat">
                                    {{ __('main.task.manage-members-hint') }}
                                </p>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="space-y-1">

                            <p class="text-xs font-semibold text-text-primary font-montserrat">
                                {{ __('main.task.search-users') }}
                            </p>

                            <div class="relative">

                                <x-lucide-search
                                    class="absolute left-4 top-1/2 -translate-y-1/2
                                        w-4 h-4 text-text-secondary"
                                />

                                <input
                                    type="text"
                                    x-model="assignedMemberQuery"
                                    @input="searchAssignedMembers()"
                                    placeholder="{{ __('main.ph.username-email') }}"
                                    class="w-full rounded-xl
                                        border-2 border-border
                                        bg-background
                                        py-2.5 pl-11 pr-10
                                        text-[12px]
                                        text-text-primary
                                        outline-none
                                        focus:border-primary font-montserrat"
                                >

                                <button
                                    x-show="assignedMemberQuery.length"
                                    @click="
                                        assignedMemberQuery = '';
                                        assignedSearchResults = [];
                                    "
                                    type="button"
                                    class="absolute right-3 top-1/2
                                        -translate-y-1/2
                                        rounded-full p-1
                                        hover:bg-surface cursor-pointer"
                                >
                                    <x-lucide-x class="w-4 h-4 text-text-primary"/>
                                </button>

                                {{-- Dropdown --}}
                                <div
                                    x-show="assignedSearchResults.length"
                                    x-transition
                                    class="absolute left-0 right-0 top-full mt-2
                                        rounded-xl border border-border
                                        bg-background
                                        shadow-xl
                                        overflow-hidden
                                        z-50"
                                >

                                    <template
                                        x-for="user in assignedSearchResults"
                                        :key="user.id"
                                    >

                                        <button
                                            type="button"
                                            @click="addAssignedMember(user)"
                                            class="w-full
                                                flex items-center gap-2
                                                px-2 py-3
                                                hover:bg-surface
                                                transition"
                                        >

                                            <img
                                                :src="user.avatar || '/images/profile.jpg'"
                                                class="w-6 h-6 rounded-full object-cover"
                                            >

                                            <div class="flex flex-col text-left">

                                                <span
                                                    class="font-semibold text-sm text-text-primary font-montserrat"
                                                    x-text="user.name"
                                                ></span>

                                                <span
                                                    class="text-[10px] text-text-secondary font-montserrat"
                                                    x-text="user.email"
                                                ></span>

                                            </div>

                                        </button>

                                    </template>

                                </div>

                            </div>

                        </div>

                        {{-- Selected members --}}
                        <div class="space-y-2">

                            <p class="text-xs font-semibold text-text-primary">
                                {{ __('main.task.assigned-members') }}
                            </p>

                            <template
                                x-for="member in assignedMembers"
                                :key="member.id"
                            >

                                <div
                                    class="flex items-center justify-between
                                        rounded-xl
                                        bg-background
                                        px-3 py-2
                                        border border-border"
                                >

                                    <div class="flex items-center gap-3">

                                        <img
                                            :src="member.avatar || '/images/profile.jpg'"
                                            class="w-9 h-9 rounded-full object-cover"
                                        >

                                        <div>

                                            <p
                                                class="font-medium text-sm text-text-primary"
                                                x-text="member.name"
                                            ></p>

                                            <p
                                                x-show="member.id == {{ $project->leader_id }}"
                                                class="text-xs text-emerald-600"
                                            >
                                                {{ __('main.task.project-leader') }}
                                            </p>

                                        </div>

                                    </div>

                                    <button
                                        type="button"
                                        @click="removeAssignedMember(member.id)"
                                        class="w-8 h-8
                                            rounded-full
                                            hover:bg-red-50
                                            text-red-500
                                            transition"
                                    >
                                        <x-lucide-x class="w-4 h-4 mx-auto"/>
                                    </button>

                                </div>

                            </template>

                        </div>

                        <template
                            x-for="member in assignedMembers"
                            :key="'hidden-' + member.id"
                        >
                            <input
                                type="hidden"
                                name="members[]"
                                :value="member.id"
                            >
                        </template>

                    </div>

                    {{-- Task TIMELINE INPUT --}}

                    <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border">
                        <div class="flex flex-row gap-2 items-center">
                            <div class="shadow-2xl shadow-pastel-green-background">
                                <x-lucide-calendar-clock class="w-5 text-pastel-green-text"/>
                            </div>
                            <p class="font-montserrat font-semibold text-[14px] text-text-primary">{{ __('main.task.timeline') }}</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">{{ __('main.task.due-optional') }}</p>

                            <div class="relative">

                                {{-- CUSTOM ICON --}}
                                <x-lucide-calendar
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                        w-4.5 h-4.5 text-text-primary pointer-events-none"
                                />

                                <input
                                    type="date"
                                    x-model="task.deadline"
                                    name="deadline"
                                    class="date-input w-full rounded-lg
                                        border-[1.5px] border-text-primary/50
                                        bg-background
                                        px-3 py-2.5
                                        text-sm placeholder:text-sm
                                        text-text-primary"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- Task Detail Input --}}

                    <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border">
                        <div class="flex flex-row gap-2 items-center">
                            <div class="shadow-2xl shadow-pastel-green-background">
                                <x-lucide-calendar-clock class="w-5 text-pastel-green-text"/>
                            </div>
                            <p class="font-montserrat font-semibold text-[14px] text-text-primary">{{ __('main.task.details') }}</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">{{ __('main.task.task-status') }}</p>

                            <div class="relative">

                                {{-- CUSTOM ICON --}}
                                <x-lucide-info
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                        w-4.5 h-4.5 text-text-primary pointer-events-none"
                                />

                                <div
                                    x-data="{ status: 'pending' }"
                                    class="relative inline-grid grid-cols-2 rounded-lg bg-gray-100 p-1">

                                    <div
                                        class="absolute left-1 top-1 h-[calc(100%-8px)] w-[calc(50%-4px)] rounded-md bg-primary-hover transition-transform duration-300"
                                        :class="status === 'in_progress' ? 'translate-x-full' : ''">
                                    </div>

                                    <label
                                        @click="status = 'pending'"
                                        :class="status === 'pending' ? 'text-white' : 'text-black'"
                                        class="relative z-10 px-6 py-2 cursor-pointer text-center">
                                        <input type="radio" name="status" value="pending" class="hidden font-montserrat" checked>
                                        {{ __('main.task.pending') }}
                                    </label>

                                    <label
                                        @click="status = 'in_progress'"
                                        :class="status === 'in_progress' ? 'text-white' : 'text-black'"
                                        class="relative z-10 px-6 py-2 cursor-pointer text-center">
                                        <input type="radio" name="status" value="in_progress" class="hidden font-montserrat">
                                        {{ __('main.task.in-progress') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">{{ __('main.task.task-priority') }}</p>

                            <div class="relative">

                                {{-- CUSTOM ICON --}}
                                <x-lucide-chart-no-axes-column-increasing
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                        w-4.5 h-4.5 text-text-primary pointer-events-none"
                                />

                                <div
                                    x-data="{ priority: 'medium' }"
                                    class="relative inline-grid grid-cols-3 rounded-lg bg-gray-100 p-1 w-72">

                                    <!-- Sliding Indicator -->
                                    <div
                                        class="absolute left-1 top-1 h-[calc(100%-8px)] w-[calc((100%-8px)/3)] rounded-md bg-primary-hover transition-all duration-300"
                                        :style="{
                                            transform:
                                                priority === 'low'
                                                    ? 'translateX(0%)'
                                                    : priority === 'medium'
                                                        ? 'translateX(100%)'
                                                        : 'translateX(200%)'
                                        }">
                                    </div>

                                    <!-- Low -->
                                    <label
                                        @click="priority = 'low'"
                                        :class="priority === 'low' ? 'text-white' : 'text-black'"
                                        class="relative z-10 cursor-pointer py-2 text-center">
                                        <input type="radio" name="priority" value="low" class="hidden font-montserrat">
                                        {{ __('main.task.low') }}
                                    </label>

                                    <!-- Medium -->
                                    <label
                                        @click="priority = 'medium'"
                                        :class="priority === 'medium' ? 'text-white' : 'text-black'"
                                        class="relative z-10 cursor-pointer py-2 text-center">
                                        <input type="radio" name="priority" value="medium" class="hidden font-montserrat" checked>
                                        {{ __('main.task.medium') }}
                                    </label>

                                    <!-- High -->
                                    <label
                                        @click="priority = 'high'"
                                        :class="priority === 'high' ? 'text-white' : 'text-black'"
                                        class="relative z-10 cursor-pointer py-2 text-center">
                                        <input type="radio" name="priority" value="high" class="hidden font-montserrat">
                                        {{ __('main.task.high') }}
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}

                    <button
                        type="submit"
                        class="flex items-center justify-center w-full rounded-2xl bg-primary  
                        hover:bg-primary-hover gap-3 py-3 text-text-contrast font-montserrat 
                        text-sm mb-1.5"
                    >
                        <x-lucide-rocket class="w-5 text-text-contrast"/>
                        {{ __('main.task.create') }}
                    </button>

                </form>
            </div>

    </div>

    <script>
        function createTaskForm() {
            return {

                assignedMembers: [],
                assignedMemberQuery: '',
                assignedSearchResults: [],

                async searchAssignedMembers() {
                    if (this.assignedMemberQuery.length < 2) {
                        this.assignedSearchResults = [];
                        return;
                    }

                    try {
                        const response = await fetch(
                            `/projects/{{ $project->id }}/members/search?q=${encodeURIComponent(this.assignedMemberQuery)}`
                        );

                        const users = await response.json();

                        this.assignedSearchResults = users.filter(user =>
                            !this.assignedMembers.some(m => m.id === user.id)
                        );

                    } catch (error) {
                        console.error(error);
                        this.assignedSearchResults = [];
                    }
                },

                addAssignedMember(user) {

                    if (this.assignedMembers.some(m => m.id === user.id))
                        return;

                    this.assignedMembers.push(user);

                    this.assignedMemberQuery = '';
                    this.assignedSearchResults = [];
                },

                removeAssignedMember(id) {

                    this.assignedMembers =
                        this.assignedMembers.filter(m => m.id !== id);

                }
            }
        }

        function projectModal(projectData) {
            return {

                project: projectData,
                menuOpen: false,
                showEdit: false,
                showDelete: false,
                selectedMembers: [],
                memberQuery: '',
                memberSearchResults: [],

                form: {
                    title: projectData.title ?? '',
                    description: projectData.description ?? '',
                    deadline: projectData.deadline ?? '',
                    accent: projectData.accent ?? '#0EA5A4',
                    icon: projectData.icon ?? 'folder',
                },

                loading: false,

                openEdit() {

                    this.menuOpen = false;

                    this.form = {
                        title: this.project.title,
                        description: this.project.description ?? '',
                        deadline: this.project.deadline
                            ? this.formatDate(this.project.deadline)
                            : '',
                        accent: this.project.accent,
                        icon: this.project.icon,
                    };

                    console.log(this.form); 

                    this.selectedMembers = (this.project.users ?? []).map(user => ({
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        avatar: user.avatar,
                    }));

                    this.memberQuery = '';
                    this.memberSearchResults = [];

                    this.showEdit = true;
                },

                openDelete() {
                    this.menuOpen = false;
                    this.showDelete = true;
                },

                closeAll() {
                    this.showEdit = false;
                    this.showDelete = false;
                    this.menuOpen = false;
                },

                formatDate(date) {
                    return new Date(date)
                        .toISOString()
                        .split('T')[0];
                },

                async searchMembers() {
                    if (this.memberQuery.trim().length < 2) {
                        this.memberSearchResults = [];
                        return;
                    }
                    try {
                        const response = await fetch(
                            `/projects/{{ $project->id }}/members/search?q=${encodeURIComponent(this.memberQuery)}`
                        );
                        const users = await response.json();
                        this.memberSearchResults = users.filter(user => {
                            if (user.id === this.project.leader_id) {
                                return false;
                            }
                            return !this.selectedMembers.some(
                                member => member.id === user.id
                            );
                        });
                    }
                    catch (error) {
                        console.error(error);
                    }
                },

                addMember(user) {
                    if (
                        this.selectedMembers.some(
                            member => member.id === user.id
                        )
                    ) {
                        return;
                    }

                    this.selectedMembers.push(user);
                    this.memberQuery = '';
                    this.memberSearchResults = [];
                },

                removeMember(memberId) {
                    this.selectedMembers =
                        this.selectedMembers.filter(
                            member => member.id !== memberId
                        );
                },

                async saveProject() {
                    this.loading = true;
                    try {
                        const response = await fetch(
                            `/projects/${this.project.id}`,
                            {
                                method: "PUT",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-CSRF-TOKEN":
                                        document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .content,
                                },
                                body: JSON.stringify({
                                    ...this.form,
                                    members: this.selectedMembers.map(member => member.id),
                                })
                            }
                        );

                        if (!response.ok) {
                            throw new Error(
                                "Failed updating project"
                            );
                        }

                        const data = await response.json();

                        // update local UI immediately
                        this.project = data.project;
                        this.closeAll();

                        // refresh to update Blade-rendered values
                        window.location.reload();
                    }
                    catch(error) {
                        console.error(error);
                        alert(
                            "Unable to update project."
                        );
                    }
                    finally {
                        this.loading = false;
                    }
                },

                async deleteProject() {
                    this.loading = true;
                    try {
                        const response = await fetch(
                            `/projects/${this.project.id}`,
                            {
                                method: "DELETE",
                                headers: {
                                    "Accept": "application/json",
                                    "X-CSRF-TOKEN":
                                        document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .content,
                                }
                            }
                        );

                        if (!response.ok) {
                            throw new Error(
                                "Failed deleting project"
                            );
                        }

                        // redirect after deletion
                        window.location.href = "/projects";
                    }
                    catch(error) {
                        console.error(error);
                        alert(
                            "Unable to delete project."
                        );
                    }
                    finally {
                        this.loading = false;
                    }
                }
            }
        }
        
        function taskModal() {
            return {
                show: false,
                editing: false,
                task: {
                    id: null,
                    title: '',
                    description: '',
                    image: '',
                    image_preview: '',
                    status: 'pending',
                    priority: 'medium',
                    deadline: '',
                    members: [],
                    leader_id: null,
                    go_collab_enabled: false,
                    go_collab_reward: 0,
                    go_collab_limit: 0
                },

                // (Internal project member)
                assignedMembers: [],
                assignedMemberQuery: '',
                assignedSearchResults: [],

                // External collabolator via Go Collab
                taskMembers: [],

                showDisableCollabWarning: false,
                showDeleteTaskWarning: false,
                showCollab: false,
                showCompleteModal: false,
                showSubmissionModal: false,
                reviewMode: false,

                newImage: null,

                originalTask: {},

                // Task Submission 
                submission: {
                    id: null,
                    task_id: null,
                    title: '',
                    submitter: '',
                    submitted_at: '',
                    submitter_avatar: '', 
                    proof_image: '',
                    proof_link: '',
                    notes: '',
                    status: '',
                },

                submissionForm: {
                    image: null,
                    preview: '',
                    link: '',
                    notes: '',
                },

                open(task) {
                    // console.trace("open() called");

                    this.task = structuredClone(task);
                    this.originalTask = JSON.stringify(task);

                    this.newImage = null; 
                    delete this.task.image_preview; 

                    this.task.go_collab_enabled =
                        Number(this.task.go_collab_enabled) === 1;

                    this.showCollab = this.task.go_collab_enabled;

                    this.assignedMembers = [...(this.task.members ?? [])];
                    this.taskMembers = [...(this.task.collaborators ?? [])];

                    this.assignedMemberQuery = '';
                    this.assignedSearchResults = [];

                    this.show = true;
                    this.editing = false;
                    this.showDeleteTaskWarning = false;
                    this.showDisableCollabWarning = false;
                },

                openComplete(task) {
                    this.task = structuredClone(task);
                    this.submissionForm = {
                        image: null,
                        preview: '',
                        link: '',
                        notes: '',
                    };
                    this.showCompleteModal = true;
                },

                previewSubmissionImage(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    this.submissionForm.image = file;
                    this.submissionForm.preview = URL.createObjectURL(file);
                },

                resetSubmission() {
                    this.submissionForm = {
                        image: null,
                        preview: '',
                        link: '',
                        notes: '',
                    };
                },

                async submitTask() {
                    try {
                        const formData = new FormData();
                        if (this.submissionForm.image) {
                            formData.append(
                                'proof_image',
                                this.submissionForm.image
                            );
                        }
                        formData.append(
                            'proof_link',
                            this.submissionForm.link
                        );
                        formData.append(
                            'notes',
                            this.submissionForm.notes
                        );
                        const response = await fetch(
                            `/tasks/${this.task.id}/submit`,
                            {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document
                                        .querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                                body: formData,
                            }
                        );
                        const data = await response.json();
                        if (!response.ok) {
                            console.error(data);
                            alert("Unable to submit task.");
                            return;
                        }
                        this.closeComplete();
                        location.reload();
                    }
                    catch(error) {
                        console.error(error);
                        alert("Unable to submit task.");
                    }
                }, 

                closeComplete() {
                    this.resetSubmission();
                    this.showCompleteModal = false;
                },

                previewTaskImage(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    this.newImage = file;
                    this.task.image_preview = URL.createObjectURL(file);
                }, 

                addAssignedMember(user) {
                    if (this.assignedMembers.some(m => m.id === user.id)) return;
                    this.assignedMembers.push(user);
                    this.task.members = [...this.assignedMembers];
                    this.assignedMemberQuery = '';
                    this.assignedSearchResults = [];
                },

                async searchAssignedMembers() {
                    if (this.assignedMemberQuery.length < 2) {
                        this.assignedSearchResults = [];
                        return;
                    }

                    try {
                        const response = await fetch(
                            `/projects/{{ $project->id }}/members/search?q=${encodeURIComponent(this.assignedMemberQuery)}`
                        );

                        // Jaga supaya assigned user nda muncul di dropdown lagi 
                        const users = await response.json();
                        this.assignedSearchResults = users.filter(user =>
                            !this.assignedMembers.some(member => member.id === user.id)
                        );
                    } catch (error) {
                        console.error(error);
                        this.assignedSearchResults = [];
                    }
                },  

                async save() {
                    try{
                        const formData = new FormData();

                        formData.append('title', this.task.title);
                        formData.append('description', this.task.description);
                        formData.append('priority', this.task.priority);
                        formData.append('status', this.task.status);
                        formData.append('deadline', this.task.deadline ?? '');

                        formData.append(
                            'go_collab_enabled',
                            this.task.go_collab_enabled ? 1 : 0
                        );

                        formData.append(
                            'go_collab_description',
                            this.task.go_collab_description ?? ''
                        );

                        formData.append(
                            'go_collab_limit',
                            this.task.go_collab_limit ?? ''
                        );

                        formData.append(
                            'go_collab_reward',
                            this.task.go_collab_reward ?? ''
                        );

                        this.assignedMembers.forEach(member => {
                            formData.append('members[]', member.id);
                        });

                        this.task.collaborators.forEach((user, index) => {
                            formData.append(`collaborators[${index}][id]`, user.id);
                        });

                        if (this.newImage) {
                            formData.append('image', this.newImage);
                        }

                        formData.append('_method', 'PUT'); 

                        const response = await fetch(`/tasks/${this.task.id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document
                                    .querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: formData
                        });

                        const data = await response.json();
                        if (!response.ok) {
                            console.error(data);
                            alert("Unable to save task.");
                            return;
                        }
                        this.originalTask = JSON.stringify(this.task);
                        location.reload();
                    } catch(error){
                        console.error(error);
                        alert("Unable to save task.");
                    }
                }, 

                removeAssignedMember(id) {
                    this.assignedMembers =
                        this.assignedMembers.filter(m => m.id !== id);
                    this.task.members = [...this.assignedMembers];
                },

                removeTaskMember(id) {
                    this.taskMembers =
                        this.taskMembers.filter(user => user.id !== id);

                    this.task.collaborators = [...this.taskMembers];
                },

                cancelEdit() {
                    // console.log(this.originalTask);
                    // console.log(this.task);
                    // console.log("Cancel clicked"); 
                    this.task = JSON.parse(this.originalTask);

                    this.assignedMembers = [...(this.originalTask.members ?? [])];
                    this.taskMembers = [...(this.originalTask.collaborators ?? [])];
                    this.assignedMemberQuery = '';
                    this.assignedSearchResults = [];

                    this.newImage = null;
                    delete this.task.image_preview; 

                    this.task.go_collab_enabled =
                        Number(this.task.go_collab_enabled) === 1;
                    this.showCollab = this.task.go_collab_enabled;

                    this.editing = false;
                },

                edit() {
                    this.editing = true;
                },

                deleteTask() {

                    fetch(`/tasks/${this.task.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to delete task');
                        }

                        return response.json();
                    })
                    .then(() => {
                        this.close();

                        window.location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Failed to delete task.');
                    });
                },

                openSubmission(submission) {
                    this.reviewMode = false; 
                    this.submission = structuredClone(submission);
                    this.showSubmissionModal = true;
                },

                closeSubmission() {
                    this.submission = {
                        id: null,
                        task_id: null,
                        title: '',
                        submitter: '',
                        submitted_at: '',
                        submitter_avatar: '', 
                        proof_image: '',
                        proof_link: '',
                        notes: '',
                        status: '',
                    };

                    this.showSubmissionModal = false;
                    this.reviewMode = false; 
                },

                openReview(submission) {
                    this.submission = structuredClone(submission);
                    this.reviewMode = true,
                    this.showSubmissionModal = true;
                },

                async approveSubmission() {
                    try {
                        const response = await fetch(
                            `/submissions/${this.submission.id}/approve`,
                            {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN':
                                        document.querySelector(
                                            'meta[name="csrf-token"]'
                                        ).content,
                                    'Accept': 'application/json',
                                },
                            }
                        );
                        const data = await response.json();
                        if (!response.ok) {
                            console.error(data);
                            alert("Unable to approve submission.");
                            return;
                        }
                        location.reload();
                    } catch (error) {
                        console.error(error);
                        alert("Unable to approve submission.");
                    }
                },

                async rejectSubmission() {
                    try {
                        const response = await fetch(
                            `/submissions/${this.submission.id}/reject`,
                            {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN':
                                        document.querySelector(
                                            'meta[name="csrf-token"]'
                                        ).content,
                                    'Accept': 'application/json',
                                },
                            }
                        );
                        const data = await response.json();
                        if (!response.ok) {
                            console.error(data);
                            alert("Unable to reject submission.");
                            return;
                        }
                        location.reload();
                    } catch (error) {
                        console.error(error);
                        alert("Unable to reject submission.");
                    }
                },

                close() {
                    this.show = false;
                    this.editing = false;

                    this.showCollab = false;
                    this.showDisableCollabWarning = false;

                    this.assignedMemberQuery = '';
                    this.assignedSearchResults = [];
                    this.assignedMembers = [];

                    this.taskMembers = [];

                    this.newImage = null;
                    this.showCompleteModal = false;
                    this.showSubmissionModal = false;

                    this.resetSubmission();
                    this.reviewMode = false;
                    this.submission = {
                        id: null,
                        task_id: null,
                        title: '',
                        submitter: '',
                        submitted_at: '',
                        submitter_avatar: '', 
                        proof_image: '',
                        proof_link: '',
                        notes: '',
                        status: '',
                    };
                }
            }
        }
    </script>
</body>
</html>