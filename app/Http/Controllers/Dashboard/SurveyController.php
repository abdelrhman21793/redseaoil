<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Dashboard\SurveyServiceInterface;
use App\Http\Requests\StructureRequest;
use App\Http\Requests\SurveyStructureRequest;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    protected $surveyService;
    public function __construct(SurveyServiceInterface $surveyService)
    {
        $this->surveyService=$surveyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveys=$this->surveyService->indexSurvey();
        return view('dashboard.survey.index',compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.survey.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SurveyStructureRequest $request)
    {

        $request->validate([
            'surveyName' => 'required',
            'structureName' => 'required',
        ]);
        $this->surveyService->surveyStore($request);
        return redirect()->route('surveys.index')
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

    public function deleteSurvey(string $id)
    {
        $survey=Survey::find($id);
        return view('dashboard.survey.delete',compact('survey'));
    }
}
