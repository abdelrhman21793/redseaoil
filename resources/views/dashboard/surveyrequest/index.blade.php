<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requests') }}
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <form style="margin-bottom: 20px" action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mbl-4 ml-10">
                <x-forms.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
                <x-forms.input name="email" placeholder="Eamil" class="mx-2" :value="request('email')"/>
                <select name="type" class="form-control mx-2" aria-placeholder="Type">
                    <option value="">All</option>
                    <option value="SUPER_ADMIN" @selected(request('type')=='SUPER_ADMIN')>Super Admin</option>
                    <option value="ADMIN" @selected(request('type')=='ADMIN')>Admin</option>
                    <option value="USER" @selected(request('type')=='USER')>User</option>
                </select>
                <button class="btn btn-dark mx-2">Search</button>
            </form> --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Survey Well</th>
                        <th scope="col">Description</th>
                        <th scope="col">User</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr>
                                <th scope="row">{{ $request->id }}</th>
                                <td>{{ $request->survey_well->name }}</td>
                                <td>{{ $request->description }}</td>
                                <td>{{ $request->user->name }}</td>
                                <td class="btn-group">
                                    <a href="{{ route('surveyrequests.edit',$request->id) }}"
                                        class="btn btn-sm btn-outline-success">Accept</a>
                                    <form method="POST" action="{{ route('surveyrequests.reject',$request->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    {{ $requests->withQueryString()->links() }}
</x-app-layout>

