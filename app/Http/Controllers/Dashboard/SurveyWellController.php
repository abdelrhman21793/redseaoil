<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Survey;
use App\Models\SurveyWell;
use App\Models\Well;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class SurveyWellController extends Controller
{
    public $well;
    public function __construct(SurveyWell $well)
    {
        $this->well = $well;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wells=$this->well->with('user')->filter($request->query())->paginate(5);
        return view('dashboard.surveywell.index',compact('wells'));
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
    public function deleteSurveyWell(string $id)
    {
        $surveyWell=SurveyWell::find($id);
        if(!$surveyWell){
            return redirect()->back()->with('fail','Wrong password please try again');
        }
        return view('dashboard.surveywell.delete',compact('surveyWell'));
    }

    public function generatePDF($id)
    {
        $surveys=Survey::with(['survey_structures.survey_structure_descriptions'=> function ($query) use ($id){
            $query->whereHas('user', function ($query) {
                $query->where('type', 'SUPER_ADMIN');
            })->orWhere('survey_well_id',$id);
        }])->get();

        $well = $this->well->with('survey_structure_description')->find($id);


        $data=[
            'well'=>$well,
            'structureDescriptions'=>$well->survey_structure_description,
            'surveys'=>$surveys
        ];

        return view('dashboard.surveywell.pdf')->with($data);

    }
}
