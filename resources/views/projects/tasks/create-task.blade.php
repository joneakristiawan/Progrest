<div
    x-show="showCreateModal"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center"
>
    <div
        class="absolute inset-0 bg-black/50"
        @click="showCreateModal = false"
    ></div>

    <div
        class="relative bg-white rounded-[32px] p-10 w-[700px] z-10"
    >
        <h1 class="text-4xl font-bold mb-8">
            Create New Task
        </h1>

        <div class="flex justify-end gap-4 mt-8">
            <button
                @click="showCreateModal = false"
                class="px-8 py-3 border rounded-2xl"
            >
                Cancel
            </button>

            <button
                class="px-8 py-3 bg-green-800 text-white rounded-2xl"
            >
                Create Task
            </button>
        </div>
    </div>
</div>