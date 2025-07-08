<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\TestServiceInterface;
use App\Http\Requests\StructureRequest;
use App\Http\Requests\TestStructureRequest;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $testService;
    public function __construct(TestServiceInterface $testService)
    {
        $this->testService=$testService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tests=$this->testService->indexTest();
        return view('dashboard.test.index',compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.test.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestStructureRequest $request)
    {

        $request->validate([
            'testName' => 'required',
            'structureName' => 'required',
        ]);
        $this->testService->testStore($request);
        return redirect()->route('tests.index')
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

    public function deleteTest(string $id)
    {
        $test=Test::find($id);
        return view('dashboard.test.delete',compact('test'));
    }
}
