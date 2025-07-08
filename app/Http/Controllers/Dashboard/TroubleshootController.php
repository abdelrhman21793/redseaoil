<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\TestServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TroubleshootServiceInterface;
use App\Http\Requests\StructureRequest;
use App\Http\Requests\TroubleshootStructureRequest;
use App\Models\Test;
use App\Models\Troubleshoot;
use Illuminate\Http\Request;

class TroubleshootController extends Controller
{
    protected $troubleshootService;
    public function __construct(TroubleshootServiceInterface $troubleshootService)
    {
        $this->troubleshootService=$troubleshootService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $troubleshoots=$this->troubleshootService->indexTroubleshoot();
        return view('dashboard.troubleshoot.index',compact('troubleshoots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.troubleshoot.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TroubleshootStructureRequest $request)
    {

        $request->validate([
            'troubleshootName' => 'required',
            'structureName' => 'required',
        ]);
        $this->troubleshootService->troubleshootStore($request);
        return redirect()->route('troubleshoots.index')
                    ->with('success','Created Successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deleteTroubleshoot(string $id)
    {
        $troubleshoot=Troubleshoot::find($id);
        return view('dashboard.troubleshoot.delete',compact('troubleshoot'));
    }
}
