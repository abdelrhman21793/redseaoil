<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="row">
                    <div class="col-sm-6">
                      <div class="card">
                        <div class="card-body" style="padding: 70px;">
                          <h1 class="card-title" style="font-size: x-large;"><b>Users</b></h1>
                          <p class="card-text">We Have <b>{{ $usersCount }} Users</b>,  <b>{{ $adminsCount }} Admins</b>, <b>{{ $superAdminsCount }} SuperAdmin</b>.</p>
                          <a href="{{ route('users.index') }}" class="btn btn-primary">Manage Users</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card">
                        <div class="card-body" style="padding: 70px;">
                          <h1 class="card-title" style="font-size: x-large;"><b>Wells</b></h1>
                          <p class="card-text">We Have <b>{{ $wellsCount }} Wells</b>.</p>
                          <a href="{{ route('wells.index') }}" class="btn btn-primary">Manage Wells</a>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</x-app-layout>
