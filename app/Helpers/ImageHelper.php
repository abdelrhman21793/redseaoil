<?php
use Illuminate\Support\Facades\Storage;


if(!function_exists('uploadFile')){

    function uploadFile($file) : string
    {
        $originalName =  $file->getClientOriginalName(); // Get file Original Name
        $imageName    = str_replace([ '(', ')', ' '],'',time() . uniqid() . $originalName);  // Set Image name
        $contents     = file_get_contents( $file );
        Storage::disk(env('FILESYSTEM_DRIVER'))->put("public/".$imageName,$contents);
        return $imageName;
    }
}

if(!function_exists('getImagePath')){

    function getImagePath( $imageName = null , $defaultImage = 'default.svg' , $driver = null  ): string
    {
        $driver = is_null($driver) ? env('FILESYSTEM_DRIVER') : $driver;
        if ( is_null( $imageName ) or is_null( Storage::disk(env('FILESYSTEM_DRIVER'))->get( '/public/' . $imageName ) ) ) // check if the image is null or the image doesn't exist
            return asset('placeholder_images/' . $defaultImage);
        else
            return Storage::disk($driver)->url(($driver == 'public' ? '/public/' : '/') . $imageName);

    }
}

if (!function_exists('uploadFiles')) {
    function uploadFiles($files): array
    {
        $uploadedImages = [];

        foreach ($files as $file) {
            $uploadedImages[] = uploadFile($file);
        }

        return $uploadedImages;
    }
}

if (!function_exists('getUserAvatar')) {
    function getUserAvatar($user): string
    {
        // If user has a profile photo and it exists, return it
        if ($user->profile_photo_path && file_exists(storage_path('app/public/' . $user->profile_photo_path))) {
            return asset('storage/' . $user->profile_photo_path);
        }

        // Return role-based default avatar
        switch ($user->type) {
            case 'SUPER_ADMIN':
                return asset('storage/super-admin-avatar.png');
            case 'ADMIN':
                return asset('storage/admin-avatar.png');
            case 'USER':
                return asset('storage/user-avatar.png');
            default:
                return asset('storage/default-avatar.png');
        }
    }
}
