<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8">
                <form class="row g-3" method="POST" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="col-md-6" style="margin-bottom: 35px">
                      <x-forms.input label="Name" name="name" placeholder="User Name" value="{{ $user->name }}"/>
                    </div>
                    <div class="row" style="margin-bottom: 35px">
                        <div class="col-md-6">
                            <x-forms.input label="Email" name="email" placeholder="User Email" value="{{ $user->email }}"/>
                        </div>
                    </div>
                    @if (Auth::user()->type=='SUPER_ADMIN')
                        <fieldset class="row mb-3" style="margin-bottom: 35px">
                            <x-forms.radio name="type" :options="['SUPER_ADMIN'=>'Super Admin','ADMIN'=>'Admin','USER'=>'User']" :checked="$user->type"/>
                        </fieldset>
                    @elseif (Auth::user()->type=='ADMIN')
                        <fieldset class="row mb-3" style="margin-bottom: 35px">
                            <x-forms.radio name="type" :options="['ADMIN'=>'Admin','USER'=>'User']" :checked="$user->type"/>
                        </fieldset>
                    @endif
                    <div class="col-md-6">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" id="image" />
                        @if ($user->profile_photo_path && file_exists(storage_path('app/public/' . $user->profile_photo_path)))
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" style="max-width: 200px; margin-top: 10px; display: block;" />
                        @else
                            <img src="{{ asset('storage/default-avatar.png') }}" alt="Default Profile Photo" style="max-width: 200px; margin-top: 10px; display: block;" />
                        @endif
                    </div>

                    <div class="form-group col-12">
                      <button type="submit" class="btn btn-outline-success">Update</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
</x-app-layout>
