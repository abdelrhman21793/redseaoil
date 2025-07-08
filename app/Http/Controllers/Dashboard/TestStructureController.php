<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\StructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TestStructureServiceInterface;
use App\Http\Requests\StructureDescRequest;
use App\Models\Option;
use App\Models\Structure;
use App\Models\Test;
use App\Models\TestStructure;
use App\Models\TestStructure_description;
use Illuminate\Http\Request;
use Throwable;

class TestStructureController extends Controller
{
    protected $structService;
    public function __construct(TestStructureServiceInterface $structService)
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
        $test=$request->test;

        return view('dashboard.teststructure.create',compact('test'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StructureDescRequest $request)
    {
        $this->structService->structStore($request);
        return redirect()->route('tests.index')
            ->with('success','Structure Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $structure=TestStructure::with('test_structure_descriptions')->findOrFail($id);
        return view('dashboard.teststructure.show',compact('structure'));
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
    public function destroy(Test $test)
    {
        abort(404);
    }
    public function deleteStruct(string $id)
    {
        $structure=TestStructure::find($id);
        if(!$structure){
            return redirect()->back()->with('fail','Wrong password please try again');
        }
        return view('dashboard.teststructure.delete',compact('structure'));
    }
    public function selectedDesc(Request $request)
    {
        $structure_descriptions[]=$request->structure_description;
        return view('dashboard.teststructure.delete-desc',compact('structure_descriptions'));
    }

    public function deleteSelectedDesc(Request $request)
    {
        if (! password_verify($request->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('tests.index');
        }
        $structureDescIds = json_decode($request->structure_descriptions);

        foreach ($structureDescIds as $structureDescId) {
            $structureDesc = TestStructure_description::find($structureDescId);

        if ($structureDesc instanceof \Illuminate\Database\Eloquent\Collection) {
            foreach ($structureDesc as $item) {
                $item->delete();
            }
        } elseif ($structureDesc) {
            $structureDesc->delete();
        }
        }
        session()->flash('success', 'Structure Description deleted successfully.');

        return redirect()->route('tests.index');
    }
}
