
<div
    x-show="showTaskModal"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center"
>
    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/50"
        @click="showTaskModal = false"
    ></div>

    {{-- Modal --}}
    <div
        class="relative bg-white rounded-[32px] p-10 w-[700px] z-10"
    >
        <h1 class="text-4xl font-bold mb-8">
            Task Details
        </h1>

        {{-- isi form disini --}}

        <div class="flex justify-end mt-8">
            <button
                @click="showTaskModal = false"
                class="px-8 py-3 border rounded-2xl"
            >
                Close
            </button>
        </div>
    </div>
</div>

