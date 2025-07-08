<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\StructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\SurveyStructureDescServiceInterface;
use App\Http\Controllers\Services\Dashboard\StructureService;
use App\Http\Controllers\Services\Dashboard\SurveyStructureService;
use App\Http\Requests\StructureDescRequest;
use App\Models\Option;
use App\Models\Structure;
use App\Models\Structure_description;
use App\Models\SurveyStructure;
use App\Models\SurveyStructure_description;
use Illuminate\Http\Request;

class SurveyStructureDescController extends Controller
{
    public $structureDescService;
    public $structureService;
    public function __construct(SurveyStructureDescServiceInterface $structureDescService,SurveyStructureService $structureService)
    {
        $this->structureDescService=$structureDescService;
        $this->structureService=$structureService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StructureDescRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $structure = SurveyStructure::with(['survey_structure_descriptions.user','survey'])->findOrFail($id);
        return view('dashboard.surveystructureDesc.edit',compact('structure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->structureDescService->structDescUpdate($request,$id);
        return redirect()->route('surveys.index')
            ->with('success','Structure Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }


    public function deleteStructDesc(string $id)
    {
        $structureDesc= SurveyStructure_description::find($id);
        return view('dashboard.surveystructureDesc.delete',compact('structureDesc'));
    }
}
