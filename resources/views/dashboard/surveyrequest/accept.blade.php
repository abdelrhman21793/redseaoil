<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accept Request') }}
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12">
        @livewire('accept-survey-request',['requestEdit'=>$requestEdit])
    </div>
</x-app-layout>

