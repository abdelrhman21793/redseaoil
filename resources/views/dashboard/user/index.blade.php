<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form style="margin-bottom: 20px" action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mbl-4 ml-10">
                <x-forms.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
                <x-forms.input name="email" placeholder="Email" class="mx-2" :value="request('email')"/>
                <select name="type" class="form-control mx-2" aria-placeholder="Type">
                    <option value="">All</option>
                    <option value="SUPER_ADMIN" @selected(request('type')=='SUPER_ADMIN')>Super Admin</option>
                    <option value="ADMIN" @selected(request('type')=='ADMIN')>Admin</option>
                    <option value="USER" @selected(request('type')=='USER')>User</option>
                </select>
                <button class="btn btn-dark mx-2">Search</button>
            </form>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>
                                    @if ($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="rounded-circle" style="width: 50px; height: 50px;">
                                    @else
                                        <img src="{{ asset('storage/Capture.PNG') }}" alt="Default Profile Photo" class="rounded-circle" style="width: 50px; height: 50px;">
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->type }}</td>
                                <td class="btn-group">
                                    <a href="{{ route('users.edit',$user->id) }}"
                                        class="btn btn-sm btn-outline-success">Edit</a>
                                    @if (Auth::user()->type=='SUPER_ADMIN')
                                        <form method="POST" action="{{ route('users.destroy',$user->id) }}">
                                            @csrf
                                            @if ($user->type=='USER'||$user->type=='ADMIN')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Delete</button>
                                            @endif
                                            @method('delete')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    {{ $users->withQueryString()->links() }}
</x-app-layout>

