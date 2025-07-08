<?php

namespace App\Http\Controllers\Services\Dashboard;
use App\Http\Controllers\Interfaces\Dashboard\UserServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface{
    protected $user;
    public function __construct(User $user)
    {
        $this->user=$user;
    }
    public function indexUser($data)
    {
        return $this->user->filter($data->query())->paginate(5);
    }
    public function userStore($data)
    {
        $path=null;
        if ($data->hasFile('image')) {
            $newImage = $data->file('image');
            $newName = rand() . '.' . $newImage->getClientOriginalExtension();
            $path = $newImage->storeAs('profile-photos', $newName, 'public');

        }
        $this->user->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'type'=>$data->type,
            'profile_photo_path'=>$path
        ]);
    }
    // public function userUpdate($data,$user)
    // {
    //     $user->update($data->all());
    // }
    public function userUpdate($data, $user)
    {
        $oldPhotoPath = $user->profile_photo_path;
        $path = $oldPhotoPath; // Initialize with the old photo path by default

        if ($data->hasFile('image')) {
            // Delete the old photo
            if ($oldPhotoPath) {
                Storage::disk('public')->delete($oldPhotoPath);
            }

            // Store the new photo
            $newImage = $data->file('image');
            $newName = rand() . '.' . $newImage->getClientOriginalExtension();
            $path = $newImage->storeAs('profile-photos', $newName, 'public');
        }

        // Update the user with the new photo path
        $user->update([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'type' => $data->type,
            'profile_photo_path' => $path
        ]);
    }
    public function userDestroy($id)
    {
        if($this->user->type=='SUPER_ADMIN'){
            abort(404);
        }
        $this->user->destroy($id);
    }
}
