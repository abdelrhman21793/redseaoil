<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\UserServiceInterface;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService=$userService;
        $this->middleware('check.super')->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users=$this->userService->indexUser($request);
        return view('dashboard.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create',[
            'user'=>new User
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try{
            $this->userService->userStore($request);
            return redirect()->route('users.index')
                ->with('success','User Created Successfully');
        }catch(\Exception $e){
            return redirect()->route('users.index')
                ->with('fail','Not Created,Please Try Again');
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try{
            $this->userService->userUpdate($request,$user);
            return redirect()->route('users.index')
                ->with('success','User Updated Successfully');
        }catch(\Exception $e){
            return redirect()->route('users.index')
                ->with('fail','Not Updated,Please Try Again');
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $this->userService->userDestroy($user->id);
            return redirect()->route('users.index')
                ->with('success','User Deleted Successfully');
        }catch(\Exception $e){
            return redirect()->route('users.index')
                ->with('fail','Not Deleted,Please Try Again');
            throw $e;
        }
    }
}
