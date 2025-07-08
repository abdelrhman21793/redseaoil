<?php

namespace App\Http\Controllers\Interfaces\Dashboard;

interface UserServiceInterface{
    public function indexUser($data);
    public function userStore($data);
    public function userUpdate($data,$id);
    public function userDestroy($id);

}
