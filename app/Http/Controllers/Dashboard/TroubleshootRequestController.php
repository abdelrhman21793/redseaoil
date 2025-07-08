<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TroubleshootRequest;
use Illuminate\Http\Request;

class TroubleshootRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests=TroubleshootRequest::where('status','pending')->with(['troubleshoot_well','user'])->paginate(5);
        return view('dashboard.troubleshootrequest.index',compact('requests'));
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
        $requestEdit= TroubleshootRequest::with(['user','troubleshoot_well'])->findOrfail($id);
        return view('dashboard.troubleshootrequest.accept',compact('requestEdit'));
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
        $request= TroubleshootRequest::with('user')->findOrfail($id);
        return view('dashboard.troubleshootrequest.delete',compact('request'));
    }
}
