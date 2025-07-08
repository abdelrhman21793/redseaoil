<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Survey;
use App\Models\SurveyWell;
use App\Models\SurveyWell_data;
use App\Models\Well;
use App\Models\Well_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
class SurveyWellController extends Controller
{
    public $well;
    public $well_data;
    public function __construct(SurveyWell $well,SurveyWell_data $well_data)
    {
        $this->well=$well;
        $this->well_data=$well_data;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wells = $this->well->where('published', 'published')
                        ->with(['user', 'survey_well_data' => function ($query) {
                            $query->whereHas('survey_structure_description', function ($subQuery) {
                                $subQuery->where('view', 'View');
                            });
                        }])
                        ->paginate(10);
        if(!$wells){
            return response()->json(['message' => 'survey wells Not Found'], 404);
        }
        return response()->json($wells,200);
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
        $well=$this->well->with(['user','survey_well_data'])->findOrFail($id);
        if(!$well){
            return response()->json(['message'=> 'Well Not Found'],404);
        }
        return response()->json($well,200);
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

    public function userWell()
    {
        $user=Auth::guard('sanctum')->user();
        $well=$this->well->where('user_id',$user->id)->get();
        return $well;
    }

    public function generatePDF(string $id)
    {
        $options = Survey::all();
        $well = $this->well->with('survey_structure_description')->find($id);

        $data = [
            'well' => $well,
            'structureDescriptions' => $well->Structure_descriptions,
            'options' => $options
        ];

        $htmlContent = View::make('dashboard.well.well_pdf', $data)->render();

        // You can store the HTML content as a temporary file or in a database
        // For simplicity, we'll store it in a temporary file in the public directory
        $fileName = 'temp_pdf_' . uniqid() . '.html';
        $filePath = public_path($fileName);
        file_put_contents($filePath, $htmlContent);

        // Return JSON response with HTML content and URL
        return response()->json([
            // 'html' => $htmlContent,
            'url' => url($fileName), // This is the URL to access the temporary HTML file
        ]);
    }
    public function calcProgress($surveyWell_id)
    {
        $surveyWell = SurveyWell::where('id', $surveyWell_id)
            ->with(['survey_well_data.survey_structure_description' => function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('type', 'SUPER_ADMIN');
                });
            }])
            ->with('survey_well_data.survey_structure_description.survey_structure.survey')
            ->first();

        $structureDescriptionSurveysCount = [];
        $structureDescriptionSurveyWellCount = [];

        if ($surveyWell->published == 'as_draft' || $surveyWell->published == 'last_draft') {
            $surveys=Survey::with(['survey_structures.survey_structure_descriptions'=>function ($query){
                        $query->whereHas('user',function($query){
                            $query->where('type','SUPER_ADMIN');
                        });
                    }])->get();
            foreach ($surveys as $survey) {
                $count = 0;

                foreach ($survey->survey_structures as $survey_structure) {
                    $count += $survey_structure->survey_structure_descriptions->count();
                }

                $structureDescriptionSurveysCount[$survey->id] = $count;
            }

            foreach ($surveyWell->survey_well_data as $wellData) {
                $surveyId = $wellData->survey_structure_description->survey_structure->survey->id;
                if (!isset($structureDescriptionSurveyWellCount[$surveyId])) {
                    $structureDescriptionSurveyWellCount[$surveyId] = 0;
                }
                $structureDescriptionSurveyWellCount[$surveyId]++;
            }

            // Perform calculations
            $result = [];
            foreach ($structureDescriptionSurveysCount as $surveyId => $count) {
                $testCount = $structureDescriptionSurveyWellCount[$surveyId] ?? 0;
                $percentage = $count > 0 ? ($testCount / $count) * 100 : 0;
                $result[$surveyId] = $percentage.'%';
            }
            return response()->json($result,200);
        }
        return response()->json(['message'=>'This Test Well Not Found,Or Published']);
    }
}
