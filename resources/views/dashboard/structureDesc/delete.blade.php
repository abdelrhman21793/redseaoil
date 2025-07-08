<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delete Structure Description') }}
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12">
        @livewire('delete-structure-desc',['structureDescId'=>$structureDesc->id])
    </div>
</x-app-layout>

