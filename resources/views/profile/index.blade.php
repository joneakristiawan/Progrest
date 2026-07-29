@extends('layouts.app')

@section('title', 'Profile')

@section('content')

@php
    $currentUser = auth()->user();

    $avatarUrl = $currentUser->avatar;
    $bannerUrl = $currentUser->banner;
@endphp

<div class="p-4 md:p-8 max-w-7xl mx-auto bg-linear-to-r from-surface to-background-gradient">
    <div class="bg-background rounded-4xl overflow-hidden shadow-sm border border-border mb-8">
        <!-- COVER -->
        <div class="relative h-36 overflow-visible">
            <img
                src="{{ $bannerUrl }}"
                alt="Cover"
                class="absolute inset-0 w-full h-full object-cover"
            >
            <!-- EDIT -->
            <button
                onclick="document.getElementById('editProfileModal').classList.remove('hidden')"
                class="absolute top-3 right-3 md:top-5 md:right-5 bg-primary hover:bg-primary-hover text-white px-3 py-2 md:px-5 text-xs md:text-base rounded-full flex items-center gap-2">
                <x-lucide-pencil class="w-4 h-4" />
                {{__('main.profile.edit-profile')}}
            </button>
        </div>
        <!-- PROFILE CONTENT -->
        <div class="relative px-4 md:px-10 pb-5">
            <!-- AVATAR -->
            <div class="mt-24 md:mt-0 md:absolute md:right-10 md:top-6 flex flex-col items-center md:items-start gap-2 text-text-secondary">
                <img
                    src="{{ $avatarUrl }}"
                    class="w-32 h-32 md:w-48 md:h-48 rounded-full object-cover border-[6px] border-background shadow-lg"
                >
            </div>
            <!-- LOCATION + JOINED -->
            @php
                $u = auth()->user();
                $place = collect([$u->city, $u->country])->filter()->implode(', ');
            @endphp
            <div class="mt-5 flex flex-col items-center md:items-start">
                <div class="flex items-center gap-2">
                    <x-lucide-calendar class="w-4 h-4" />
                    {{__('main.profile.joined')}} {{ $u->created_at?->format('M Y') ?? 'Jan 2026' }}
                </div>
                @if ($place)
                    <div class="flex items-center gap-2">
                        <x-lucide-map-pin class="w-4 h-4" />
                        {{ $place }}
                    </div>
                @endif
            </div>

            <!-- PROFILE INFO -->
            <div class="pt-28 md:pt-6 md:ml-54 text-center md:text-left">
                <h1 class="font-montserrat text-2xl md:text-3xl font-bold break-words font-bold text-text-primary">
                    {{ auth()->user()->username }}
                </h1>
                <p class="font-montserrat text-lg text-text-secondary mt-px">
                    {{ auth()->user()->name }}
                </p>
                <p class="mt-2 max-w-full md:max-w-lg break-words whitespace-pre-line font-montserrat text-text-secondary whitespace-pre-line">{{ auth()->user()->about ?: __('main.profile.no-bio') }}</p>
            </div>
        </div>

        <!-- STATS -->
        <div class="px-8 pb-4">
            <div class="grid grid-cols-2 md:grid-cols-4 bg-card border border-border rounded-3xl overflow-hidden">
                <div class="flex flex-col items-center py-3">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-folder-git class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-montserrat text-3xl font-bold text-text-primary">{{ $stats['projects_joined'] }}</span>
                    </div>
                    <span class="text-xs md:text-sm text-center px-2 text-text-secondary">
                        {{__('main.profile.projects-joined')}}
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-clipboard-list class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-montserrat text-3xl font-bold text-text-primary">{{ $stats['tasks_completed'] }}</span>
                    </div>
                    <span class="text-text-secondary">
                        {{__('main.profile.tasks-completed')}}
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-users class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-montserrat text-3xl font-bold text-text-primary">{{ $stats['collaborations'] }}</span>
                    </div>
                    <span class="text-text-secondary">
                        {{__('main.profile.collaborations')}}
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-star class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-montserrat text-3xl font-bold text-text-primary">{{ $stats['points'] }}</span>
                    </div>
                    <span class="text-text-secondary">
                        {{__('main.profile.total-points')}}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ABOUT -->
        <div class="bg-background rounded-4xl p-7 shadow-sm border border-border flex flex-col h-auto md:h-[600px]">

            <div class="flex flex-col flex-1 min-h-0">

                <div class="flex justify-between items-center mb-5 shrink-0">
                    <h2 class="font-montserrat text-2xl font-semibold text-text-primary">
                        {{ __('main.profile.more-about') }}
                    </h2>
                    <x-lucide-lightbulb class="w-6 h-6 text-primary"/>
                </div>

                <p class="font-montserrat text-text-secondary leading-relaxed text-sm whitespace-pre-line flex-1 min-h-0 overflow-y-auto pr-1">{{ auth()->user()->more_about ?: __('main.profile.no-description') }}</p>

            </div>

            <div class="mt-6 flex flex-col gap-5 shrink-0">

                @unless (auth()->user()->hide_email)
                    <div class="flex items-center gap-3 text-text-secondary">
                        <x-lucide-mail class="w-5 h-5 text-primary shrink-0" />

                        <span class="font-montserrat text-[12px] truncate">
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                @endunless

                @if (auth()->user()->linkedin)
                    <div class="flex items-center gap-3 text-text-secondary">
                        <x-lucide-linkedin class="w-5 h-5 text-primary" />

                        <span class="font-montserrat text-[12px]">
                            {{ auth()->user()->linkedin }}
                        </span>
                    </div>
                @endif

            </div>
        </div>

        <!-- TASK HELPED -->
        <div class="bg-background rounded-4xl p-6 shadow-sm border border-border h-[600px] flex flex-col">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-montserrat text-2xl font-semibold text-text-primary">
                    {{ __('main.profile.tasks-helped') }}
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-montserrat font-bold text-2xl leading-none">
                    {{ $tasksHelped->count() }}
                </div>

            </div>

            <div class="flex flex-col gap-4 flex-1 overflow-y-auto">

                @forelse($tasksHelped as $task)

                    <div
                        class="relative overflow-hidden rounded-3xl p-3 shadow-sm text-white bg-primary shrink-0"
                    >

                        <!-- Top Section -->
                        <div class="flex gap-3 mb-4 row justify-between items-center">
                            <div class="flex row gap-3 items-center">
                                <div class="w-8 h-8 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center">
                                    <x-lucide-list-todo class="w-4 h-4" />
                                </div>
                                <h3 class="font-montserrat text-xl font-bold leading-tight">
                                    {{ $task->project?->title ?? __('main.profile.no-project') }}
                                </h3>
                            </div>
                            <div class="px-2.5 h-8 rounded-xl bg-white/20 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                                <span class="font-montserrat font-semibold text-xs capitalize">
                                    {{ $task->priority }}
                                </span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="w-full h-px bg-white/35 rounded-lg mb-4"></div>

                        <!-- Task Title -->
                        <p class="font-montserrat text-sm leading-relaxed text-white/90">
                            {{ $task->title }}
                        </p>

                        <!-- Footer -->
                        <div class="flex items-center justify-between mt-4">

                            <div class="flex items-center gap-2 text-white/80">
                                <x-lucide-calendar class="w-4 h-4" />
                                <span class="text-sm font-montserrat">
                                    {{ ($task->deadline ?? $task->created_at)?->format('d M Y') }}
                                </span>
                            </div>

                            <div class="px-3 py-1 rounded-full bg-white/15 border border-white/10 flex items-center">
                                <span class="text-xs font-semibold font-montserrat capitalize">
                                    {{ str_replace('_', ' ', $task->status) }}
                                </span>
                            </div>

                        </div>
                    </div>

                @empty
3xl
                    <p class="font-montserrat text-sm text-text-secondary">
                        {{ __('main.profile.no-tasks-helped') }}
                    </p>

                @endforelse

            </div>
        </div>

        <!-- TASK CREATED -->
        <div class="bg-background rounded-4xl p-6 shadow-sm border border-border h-[600px] flex flex-col">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-montserrat text-2xl font-semibold text-text-primary">
                    {{ __('main.profile.tasks-created') }}
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-montserrat font-bold text-2xl leading-none">
                    {{ $tasksCreated->count() }}
                </div>

            </div>

            <div class="flex flex-col gap-4 flex-1 overflow-y-auto">

                @forelse($tasksCreated as $task)

                    <div
                        class="relative overflow-hidden rounded-3xl p-3 shadow-sm text-white bg-primary shrink-0"
                    >

                        <!-- Top Section -->
                        <div class="flex gap-3 mb-4 row justify-between items-center">
                            <div class="flex row gap-3 items-center">
                                <div class="w-8 h-8 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center">
                                    <x-lucide-list-todo class="w-4 h-4" />
                                </div>
                                <h3 class="font-montserrat text-xl font-bold leading-tight">
                                    {{ $task->project?->title ?? __('main.profile.no-project') }}
                                </h3>
                            </div>
                            <div class="px-2.5 h-8 rounded-xl bg-white/20 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                                <span class="font-montserrat font-semibold text-xs capitalize">
                                    {{ $task->priority }}
                                </span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="w-full h-px bg-white/35 rounded-lg mb-4"></div>

                        <!-- Task Title -->
                        <p class="font-montserrat text-sm leading-relaxed text-white/90">
                            {{ $task->title }}
                        </p>

                        <!-- Footer -->
                        <div class="flex items-center justify-between mt-4">

                            <div class="flex items-center gap-2 text-white/80">
                                <x-lucide-calendar class="w-4 h-4" />
                                <span class="text-sm font-montserrat">
                                    {{ ($task->deadline ?? $task->created_at)?->format('d M Y') }}
                                </span>
                            </div>

                            <div class="px-3 py-1 rounded-full bg-white/15 border border-white/10 flex items-center">
                                <span class="text-xs font-semibold font-montserrat capitalize">
                                    {{ str_replace('_', ' ', $task->status) }}
                                </span>
                            </div>

                        </div>
                    </div>

                @empty

                    <p class="font-montserrat text-sm text-text-secondary">
                        {{ __('main.profile.no-tasks-created') }}
                    </p>

                @endforelse

            </div>

        </div>

    </div>

    {{-- Language Switch --}}

    <div class="flex items-center justify-between rounded-4xl border border-border bg-background p-6 shadow-sm mt-8">
        {{-- Left --}}
        <div class="flex items-center gap-4 font-montserrat">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary">
                <x-lucide-languages class="w-6 h-6 text-text-contrast" />
            </div>
            <div>
                <h3 class="text-lg font-semibold text-text-primary">
                    {{ __('main.profile.language-pref') }}
                </h3>
                <p class="mt-1 text-sm text-text-secondary">
                    {{ __('main.profile.language-hint') }}
                </p>
            </div>
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-3">
            <span
                class="text-sm font-semibold transition-colors
                {{ app()->getLocale() == 'id'
                    ? 'text-text-primary'
                    : 'text-placeholder' }}">
                ID
            </span>
            <label class="relative inline-flex cursor-pointer items-center">
                <input
                    type="checkbox"
                    class="peer sr-only"
                    {{ app()->getLocale() == 'en' ? 'checked' : '' }}
                    onchange="window.location.href='{{ app()->getLocale() == 'en'
                        ? route('language.switch', 'id')
                        : route('language.switch', 'en') }}'"
                >
                <div class="h-7 w-14 rounded-full bg-secondary transition-all duration-300 peer-checked:bg-primary"></div>
                <div
                    class="absolute left-1 flex h-5 w-5 items-center justify-center rounded-full bg-white shadow transition-all duration-300 peer-checked:translate-x-7">
                    <i class="fa-solid fa-check text-[10px] text-secondary opacity-0 transition-opacity peer-checked:opacity-100"></i>
                </div>
            </label>
            <span
                class="text-sm font-semibold transition-colors
                {{ app()->getLocale() == 'en'
                    ? 'text-text-primary'
                    : 'text-placeholder' }}">
                EN
            </span>
        </div>
    </div>
</div>

<!-- EDIT PROFILE MODAL -->
<div
    id="editProfileModal"
    class="fixed inset-0 z-[999] hidden bg-black/40 backdrop-blur-sm"
>

    <!-- CENTER -->
    <div class="min-h-screen flex items-center justify-center p-4">

        <!-- MODAL -->
        <div
            class="w-full max-w-[850px] max-h-[90vh] flex flex-col bg-background rounded-[32px] overflow-hidden shadow-2xl"
        >

            <!-- HEADER -->
            <div class="bg-primary h-[70px] shrink-0 px-8 flex items-center justify-between">

                <div class="flex items-center gap-3 text-white">
                    <x-lucide-pencil class="w-6 h-6" />

                    <h2 class="font-montserrat text-2xl font-bold">
                        {{ __('main.profile.edit-profile') }}
                    </h2>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('editProfileModal').classList.add('hidden')"
                    class="text-white cursor-pointer"
                >
                    <x-lucide-x class="w-8 h-8" />
                </button>

            </div>

            <!-- FORM-->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col min-h-0 overflow-hidden">
                @csrf

                <!-- Hidden file inputs -->
                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
                <input type="file" id="bannerInput" name="banner" accept="image/*" class="hidden">

            <!-- BANNER -->
            <div class="relative h-[100px] shrink-0">

                <img
                    id="bannerPreview"
                    src="{{ $bannerUrl }}"
                    alt=""
                    class="w-full h-full object-cover"
                >

                <div class="absolute inset-0 flex items-center justify-between px-6">

                    <!-- LEFT -->
                    <div class="flex items-center gap-4">

                        <img
                            id="avatarPreview"
                            src="{{ $avatarUrl }}"
                            alt=""
                            class="w-[65px] h-[65px] rounded-full border-4 border-background object-cover"
                        >

                    </div>

                    <!-- RIGHT -->
                    <div class="flex gap-3">

                        <button
                            type="button"
                            onclick="document.getElementById('avatarInput').click()"
                            class="bg-primary hover:bg-primary-hover cursor-pointer transition text-white px-5 py-2 rounded-full flex items-center gap-2 font-montserrat text-sm font-semibold"
                        >
                            <x-lucide-upload class="w-4 h-4" />
                            {{ __('main.profile.upload-avatar') }}
                        </button>

                        <button
                            type="button"
                            onclick="document.getElementById('bannerInput').click()"
                            class="bg-primary hover:bg-primary-hover cursor-pointer transition text-white px-5 py-2 rounded-full flex items-center gap-2 font-montserrat text-sm font-semibold"
                        >
                            <x-lucide-upload class="w-4 h-4" />
                            {{ __('main.profile.upload-banner') }}
                        </button>

                    </div>

                </div>

            </div>

            <!-- FIELDS -->
            <div class="p-6 flex-1 overflow-y-auto min-h-0">

                <!-- ROW -->
                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            {{ __('main.profile.username') }}
                        </label>

                        <input
                            type="text"
                            name="username"
                            required
                            value="{{ old('username', $currentUser->username) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            {{ __('main.profile.full-name') }}
                        </label>

                        <input
                            type="text"
                            name="name"
                            required
                            value="{{ old('name', $currentUser->name) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                </div>

                <!-- LOCATION -->
                <div class="mt-5 grid grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            {{ __('main.profile.city') }}
                            <span class="font-normal text-text-secondary">
                                {{ __('main.profile.optional') }}
                            </span>
                        </label>

                        <input
                            type="text"
                            name="city"
                            value="{{ old('city', $currentUser->city) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            {{ __('main.profile.country') }}
                            <span class="font-normal text-text-secondary">
                                {{ __('main.profile.optional') }}
                            </span>
                        </label>

                        <input
                            type="text"
                            name="country"
                            value="{{ old('country', $currentUser->country) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                </div>

                <!-- ABOUT ME -->
                <div class="mt-5">

                    <div class="flex items-end justify-between mb-2">
                        <label class="font-montserrat font-bold text-base">
                            {{ __('main.profile.about-me') }}
                            <span class="font-normal text-text-secondary">
                                {{ __('main.profile.about-hint') }}
                            </span>
                        </label>
                        <span data-counter-for="about" class="hidden font-montserrat text-sm font-semibold text-red-600"></span>
                    </div>

                    <textarea
                        rows="2"
                        name="about"
                        class="w-full border-2 border-border rounded-xl p-4 resize-none"
                    >{{ old('about', $currentUser->about) }}</textarea>

                </div>

                <!-- MORE ABOUT ME -->
                <div class="mt-5">

                    <div class="flex items-end justify-between mb-2">
                        <label class="font-montserrat font-bold text-base">
                            {{ __('main.profile.more-about') }}
                            <span class="font-normal text-text-secondary">
                                {{ __('main.profile.more-about-hint') }}
                            </span>
                        </label>
                        <span data-counter-for="more_about" class="hidden font-montserrat text-sm font-semibold text-red-600"></span>
                    </div>

                    <textarea
                        rows="6"
                        name="more_about"
                        class="w-full border-2 border-border rounded-xl p-4 resize-none"
                    >{{ old('more_about', $currentUser->more_about) }}</textarea>

                </div>

                <!-- FOOTER -->
                <div class="mt-5 flex justify-between items-end">

                    <div class="w-[45%]">

                        <label class="block mb-2 font-montserrat font-bold text-base">
                            {{ __('main.profile.linkedin') }}
                            <span class="font-normal text-text-secondary">
                                {{ __('main.profile.optional') }}
                            </span>
                        </label>

                        <input
                            type="text"
                            name="linkedin"
                            value="{{ old('linkedin', $currentUser->linkedin) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >

                    </div>

                    <div class="flex items-center gap-6">

                        <label class="flex items-center gap-2">

                            <input
                                type="checkbox"
                                name="hide_email"
                                value="1"
                                {{ old('hide_email', $currentUser->hide_email) ? 'checked' : '' }}
                                class="w-5 h-5"
                            >

                            <span class="font-montserrat text-base">
                                {{ __('main.profile.hide-email') }}
                            </span>

                        </label>

                        <button
                            type="submit"
                            class="bg-primary hover:bg-primary-hover cursor-pointer transition text-white px-8 py-3 rounded-full flex items-center gap-2 font-montserrat text-xl font-bold"
                        >
                            <x-lucide-save class="w-5 h-5" />
                            {{ __('main.profile.save') }}
                        </button>

                    </div>

                </div>

            </div>
            <!-- /FIELDS -->

            </form>

        </div>

    </div>

</div>

<!-- SUCCESS TOAST -->
@if (session('success'))
    <div class="fixed bottom-6 right-6 z-[1000] flex flex-col-reverse gap-2">
        <div
            id="profileToast"
            class="max-w-sm bg-primary text-white px-6 py-3 rounded-2xl shadow-lg font-montserrat font-semibold flex items-start gap-2"
        >
            <x-lucide-circle-check class="w-5 h-5 shrink-0 mt-0.5" />
            <span>{{ session('success') }}</span>
        </div>
    </div>
    <script>
        setTimeout(() => document.getElementById('profileToast')?.remove(), 4000);
    </script>
@endif

<!-- ERROR TOASTS (one per error) -->
@if ($errors->any())
    <div
        id="profileErrorToasts"
        class="fixed bottom-6 right-6 z-[1000] flex flex-col-reverse gap-2"
    >
        @foreach ($errors->all() as $error)
            <div
                class="profile-error-toast max-w-sm bg-red-600 text-white px-6 py-3 rounded-2xl shadow-lg font-montserrat font-semibold flex items-start gap-2"
            >
                <x-lucide-circle-alert class="w-5 h-5 shrink-0 mt-0.5" />
                <span>{{ $error }}</span>
            </div>
        @endforeach
    </div>
    <script>
        document.querySelectorAll('#profileErrorToasts .profile-error-toast')
            .forEach((toast, i) => setTimeout(() => toast.remove(), 4000 + i * 400));
    </script>
@endif

<script>
    // live preview
    (function () {
        const KB = 1024;
        const FILE_TOO_LARGE = @json(__('main.toast.file-too-large-client', ['label' => '%LABEL%', 'max' => '%MAX%']));
        const LIMITS = {
            avatarInput: { maxBytes: 1024 * KB, label: @json(__('main.toast.avatar')), max: '1 MB' },
            bannerInput: { maxBytes: 2048 * KB, label: @json(__('main.toast.banner')), max: '2 MB' },
        };

        function showErrorToast(message) {
            let container = document.getElementById('profileErrorToasts');
            if (!container) {
                container = document.createElement('div');
                container.id = 'profileErrorToasts';
                container.className = 'fixed bottom-6 right-6 z-[1000] flex flex-col-reverse gap-2';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = 'profile-error-toast max-w-sm bg-red-600 text-white px-6 py-3 rounded-2xl shadow-lg font-montserrat font-semibold flex items-start gap-2';

            // alert icon
            toast.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>';
            const text = document.createElement('span');
            text.textContent = message;

            toast.appendChild(text);
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 4000);
        }

        function bindPreview(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (!input || !preview) return;

            input.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) return;

                const limit = LIMITS[inputId];
                if (limit && file.size > limit.maxBytes) {
                    showErrorToast(FILE_TOO_LARGE.replace('%LABEL%', limit.label).replace('%MAX%', limit.max));
                    this.value = '';            // clear so it is never submitted
                    return;
                }

                preview.src = URL.createObjectURL(file);
            });
        }

        bindPreview('avatarInput', 'avatarPreview');
        bindPreview('bannerInput', 'bannerPreview');

        // word count
        function bindCounter(name, limit) {
            const field = document.querySelector(`[name="${name}"]`);
            const counter = document.querySelector(`[data-counter-for="${name}"]`);
            if (!field || !counter) return;

            const update = () => {
                const over = field.value.length - limit;
                if (over > 0) {
                    counter.textContent = '-' + over;
                    counter.classList.remove('hidden');
                } else {
                    counter.classList.add('hidden');
                }
            };

            field.addEventListener('input', update);
            update();
        }

        bindCounter('about', 200);
        bindCounter('more_about', 2000);

        @if ($errors->any())
            document.getElementById('editProfileModal')?.classList.remove('hidden');
        @endif
    })();
</script>

@endsection