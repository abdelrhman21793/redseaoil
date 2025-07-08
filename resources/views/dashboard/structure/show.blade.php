<x-alert />
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Structure : {{ $structure->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <x-alert />
            <div>
                <form method="POST" action="{{ route('structures.selectedDesc') }}">
                    @csrf
                    @foreach ($structure->structure_descriptions as $structure_description)
                        <div>
                            <input type="checkbox" name="structure_description[]" id="structure_description_{{ $structure_description->id }}"
                                value="{{ $structure_description->id }}">
                            <label for="structure_description_{{ $structure_description->id }}">{{ $structure_description->input }}</label>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
