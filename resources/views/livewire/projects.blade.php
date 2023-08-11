<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Projects') }}
    </h2>
</x-slot>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="bg-indigo-100 border-indigo-500 text-indigo-900 shadow-md mb-4 px-4 py-2"
                    role="alert">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                        <button @click="show = false" class="inline-flex font-extrabold text-indigo-900 focus:outline-none focus:text-indigo-500 transition ease-in-out duration-150">
                            &emsp; x
                        </button>
                    </div>
                </div>
            @endif
            <x-button wire:click="create()" class="mb-4">Add New Project</x-button>
            <x-modal wire:model.defer="modalOpen">
                @include('livewire.projects-form')
            </x-modal>
            <x-modal wire:model.defer="modalDeleteOpen">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3>
                        Are you sure ?
                    </h3>
                </div>
                <div class="ml-6 mb-4">
                    <x-button wire:click.prevent="delete()" type="button" class="mr-2">Delete</x-button>
                    <x-secondary-button wire:click="closeModal()" type="button">Cancel</x-secondary-button>
                </div>
            </x-modal>
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-400 text-white">
                    <th class="px-4 py-2 w-20">No.</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Is Public</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $item)
                    <tr >
                        <td class="border px-4 py-2">{{ $item->id }}</td>
                        <td class="border px-4 py-2">{{ $item->title }}</td>
                        <td class="border px-4 py-2">
                            <img src="{{ asset('images/projects').'/'.$item->image }}" class="w-20">
                        </td>
                        <td class="border px-4 py-2">
                            @if($item->is_public) Public @else Draft @endif
                        </td>
                        <td class="border px-4 py-2">
                            <x-secondary-button wire:click="edit({{ $item->id }})" class="mr-2">
                                Edit
                            </x-secondary-button>
                            <x-danger-button wire:click="deleteId({{ $item->id }})" data-toggle="modal" data-target="#exampleModal">
                                Delete
                            </x-danger-button>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
