<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\OptionServiceInterface;
use App\Http\Requests\StructureRequest;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    protected $optionService;
    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService=$optionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options=$this->optionService->indexOption();
        return view('dashboard.option.index',compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.option.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StructureRequest $request)
    {

        // $request->validate([
        //     'optionName' => 'required',
        //     'structureName' => 'required',
        // ]);
        $this->optionService->optionStore($request);
        return redirect()->route('optionStructures.index')
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

    public function deleteOption(string $id)
    {
        $option=Option::find($id);
        return view('dashboard.option.delete',compact('option'));
    }
}
