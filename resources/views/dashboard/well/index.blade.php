<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('wells') }}
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form style="margin-bottom: 20px" action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mbl-4 ml-10">
                <x-forms.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
                <x-forms.input name="from" placeholder="From" class="mx-2" :value="request('from')"/>
                <x-forms.input name="to" placeholder="To" class="mx-2" :value="request('to')"/>
                <select name="user_id" class="form-control mx-2" aria-placeholder="User">
                    <option value="">All</option>
                    @foreach ($wells as $well)
                        <option value="{{ $well->user->id }}" @selected(request('user_id')=='{{ $well->user->id }}')>
                            {{ $well->user->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-dark mx-2">Search</button>
            </form>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($wells as $well)
                            <tr>
                                <th scope="row">{{ $well->id }}</th>
                                <td>{{ $well->name }}</td>
                                <td>{{ $well->from }}</td>
                                <td>{{ $well->to }}</td>
                                <td>{{ $well->user->name }}</td>
                                <td class="btn-group">
                                    {{-- <a href=""
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete</button>
                                        @method('delete')
                                    </form> --}}
                                    <a href="{{ route('wells.delete',$well->id) }}" class="btn btn-sm btn-outline-danger">delete</a>
                                    <a href="{{ route('wells.generatePDF',$well->id) }}"
                                        class="btn btn-sm btn-outline-success">PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    {{ $wells->withQueryString()->links() }}
</x-app-layout>

