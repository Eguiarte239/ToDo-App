<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 ">
            To Do App
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div>
                    <x-jet-button wire:click="newNote" class="mb-4">
                        + New task
                    </x-jet-button>
                </div>

                <div class="grid gap-2 md:grid-cols-4" wire:sortable="updateTaskOrder">
                    @foreach ($tasks as $task)
                        <div wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}" class="mb-2 bg-white rounded-lg shadow-md p-2 border">
                            <div class="px-2" wire:sortable.handle>
                                <div class="flex flex-row justify-between">
                                    <div class="font-bold text-xl mb-2" >
                                        {{ $task->title }}
                                        <img src="{{ $task->image }}" alt="Image" style="width: 100px; height: 150px;">
                                    </div>
                                    <div>
                                        <button wire:click="editNote({{ $task->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                                <p class="text-gray-700 text-base">
                                    {{ $task->content }}
                                    {{ $task->priority }}
                                </p>
                            </div>
                            <span
                                class="flex flex-row bg-purple-200 rounded-lg px-3 py-1 text-sm font-semibold text-purple-800 mr-2 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $task->start_task }}
                            </span>
                            <span
                                class="flex flex-row bg-purple-200 rounded-lg px-3 py-1 text-sm font-semibold text-purple-800 mr-2 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $task->end_task }}
                            </span>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    {{-- New note modal --}}
    <x-jet-dialog-modal wire:model="openModal">
        <x-slot name="title">
            Add new note
        </x-slot>

        <x-slot name="content">
            <div class="mb-6">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">
                    Title
                </label>
                <input wire:model="title" type="text" id="first_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                <x-jet-input-error for="title"></x-jet-input-error>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-4">
                <div>
                    <label for="priority" class="block mb-2 text-sm font-medium text-gray-900">
                        Priority
                    </label>
                    <select name="priority" id="priority"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" wire:model="priority">
                        <option value="" hidden selected></option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                    <x-jet-input-error for="priority"></x-jet-input-error>
                </div>
                <div>
                    <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">
                        Start time
                    </label>
                    <input wire:model="start_time" id="start_time" type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                    <x-jet-input-error for="start_time"></x-jet-input-error>
                </div>
                <div>
                    <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">
                        End time
                    </label>
                    <input wire:model="end_time" type="date" id="end_time"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                    <x-jet-input-error for="end_time"></x-jet-input-error>
                </div>
                <div>
                    <label for="hour_estimate" class="block mb-2 text-sm font-medium text-gray-900">
                        Hour estimate
                    </label>
                    <input wire:model="hour_estimate" type="text" id="hour_estimate"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                    <x-jet-input-error for="hour_estimate"></x-jet-input-error>
                </div>
            </div>
            <input type="file" wire:model="image" id="{{ $imageId }}">
            <x-jet-input-error for="image"></x-jet-input-error>
            <div wire:ignore>
                <label for="content" class="block mb-2 text-sm font-medium text-gray-900">
                </label>
                <textarea wire:model="content" name="contentTask" id="contentTask" cols="30" rows="10" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
            </div>
            <x-jet-input-error for="content"></x-jet-input-error>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('openModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            
            @if ($editTask)
                <x-jet-secondary-button
                    class="ml-3 bg-red-500 text-white hover:text-white hover:bg-red-700 active:bg-red-50"
                    wire:loading.attr="disabled" wire:click="deleteTask({{ $this->task->id }})">
                    {{ __('Delete') }}
                </x-jet-secondary-button>
                <x-jet-button class="ml-3" wire:click="editTask({{ $this->task->id }})" wire:loading.attr="disabled" wire:target="save, image">
                    Save task
                </x-jet-button>
            @else
                <x-jet-button class="ml-3" wire:click="saveTask" wire:loading.attr="disabled" wire:target="save, image">
                    Save task
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>


        <script>
            ClassicEditor
                .create(document.querySelector('#contentTask'))
                .then(function(contentTask) => {
                    contentTask.model.document.on('change:data', () => {
                        @this.set('content', contentTask.getData())
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
</div>
