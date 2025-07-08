<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Models\TestRequest;
use Illuminate\Http\Request;

class TestRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests=TestRequest::where('status','pending')->with(['test_well','user'])->paginate(5);
        return view('dashboard.testrequest.index',compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        $requestEdit= TestRequest::with(['user','test_well'])->findOrfail($id);
        return view('dashboard.testrequest.accept',compact('requestEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }

    public function reject(string $id)
    {
        $request= TestRequest::with('user')->findOrfail($id);
        return view('dashboard.testrequest.delete',compact('request'));
    }
}
