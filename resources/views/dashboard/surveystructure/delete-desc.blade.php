<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delete Structure') }}
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12">
        <div>
            <div class="card  mx-auto" style="width: 500px;">
                <form method="POST" action="{{ route('surveystructures.deleteSelectedDesc') }}">
                    @csrf
                    <div class="card-body" style="margin-left: 45px;">
                        <label class="card-title">Enter Your Password To Continue Deletion:-</label>
                        <input type="hidden" name="structure_descriptions" value="{{ json_encode($structure_descriptions) }}">
                        <input type="password" name="password" placeholder="Enter your password">
                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>

