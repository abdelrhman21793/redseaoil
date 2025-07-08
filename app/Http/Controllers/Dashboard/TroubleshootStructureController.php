<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\StructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TroubleshootStructureServiceInterface;
use App\Http\Requests\StructureDescRequest;
use App\Models\Option;
use App\Models\Structure;
use App\Models\Troubleshoot;
use App\Models\TroubleshootStructure;
use App\Models\TroubleshootStructure_description;
use Illuminate\Http\Request;
use Throwable;

class TroubleshootStructureController extends Controller
{
    protected $structService;
    public function __construct(TroubleshootStructureServiceInterface $structService)
    {
        $this->structService=$structService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $troubleshoot=$request->troubleshoot;

        return view('dashboard.troubleshootstructure.create',compact('troubleshoot'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StructureDescRequest $request)
    {
        $this->structService->structStore($request);
        return redirect()->route('troubleshoots.index')
            ->with('success','Structure Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $structure=TroubleshootStructure::with('troubleshoot_structure_descriptions')->findOrFail($id);
        return view('dashboard.troubleshootstructure.show',compact('structure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
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
    public function destroy(Troubleshoot $troubleshoot)
    {
        abort(404);
    }
    public function deleteStruct(string $id)
    {
        $structure=TroubleshootStructure::find($id);
        if(!$structure){
            return redirect()->back()->with('fail','Wrong password please try again');
        }
        return view('dashboard.troubleshootstructure.delete',compact('structure'));
    }
    public function selectedDesc(Request $request)
    {
        $structure_descriptions[]=$request->structure_description;
        return view('dashboard.troubleshootstructure.delete-desc',compact('structure_descriptions'));
    }

    public function deleteSelectedDesc(Request $request)
    {
        if (! password_verify($request->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('troubleshoots.index');
        }
        $structureDescIds = json_decode($request->structure_descriptions);

        foreach ($structureDescIds as $structureDescId) {
            $structureDesc = TroubleshootStructure_description::find($structureDescId);

        if ($structureDesc instanceof \Illuminate\Database\Eloquent\Collection) {
            foreach ($structureDesc as $item) {
                $item->delete();
            }
        } elseif ($structureDesc) {
            $structureDesc->delete();
        }
        }
        session()->flash('success', 'Structure Description deleted successfully.');

        return redirect()->route('troubleshoots.index');
    }
}
