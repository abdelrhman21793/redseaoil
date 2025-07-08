<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Front\SurveyWellDataServiceInterface;
use App\Http\Requests\SaveSurveyWellDraftRequest;
use App\Models\SurveyRequest;
use App\Http\Controllers\Interfaces\Front\WellDataServiceInterface;
use App\Http\Requests\PublishSurveyWellRequest;
use App\Http\Requests\PublishWellRequest;
use App\Models\Request as ModelsRequest;
use App\Models\Structure;
use App\Models\Structure_description;
use App\Models\SurveyStructure;
use App\Models\SurveyStructure_description;
use App\Models\SurveyWell;
use App\Models\SurveyWell_data;
use App\Models\Well;
use App\Models\Well_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;



class SurveyWellDataController extends Controller
{
    public $well,$well_data,$structure,$structure_description,$wellDataService;
    public function __construct(SurveyWell $well,SurveyWell_data $well_data,SurveyStructure $structure,SurveyStructure_description $structure_description,SurveyWellDataServiceInterface $wellDataService)
    {
        $this->well=$well;
        $this->well_data=$well_data;
        $this->wellDataService=$wellDataService;
        $this->structure=$structure;
        $this->structure_description=$structure_description;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function store(PublishSurveyWellRequest $request)
    {
        try{
            if(isset($request->survey_well_id)){
                $this->wellDataService->publishOldWell($request,'published');
                return response()->json(['message' => 'Survey Well Created Successfully'], 200);
            }else{
                $this->wellDataService->publishNewWell($request,'published');
                return response()->json(['message' => 'Survey Well Created Successfully'], 200);
            }
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(string $id)
    {
        $well=$this->well->with('survey_well_data.survey_structure_description.survey_structure.survey')
                ->findOrFail($id);
        if(!$well || $well->published=='published'){
            return response()->json(['message'=> 'this survey well is not found,or already published'],404);
        }else{
            return response()->json($well,200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wellRequest=SurveyRequest::with('survey_well.survey_well_data')->where('id',$id)->where('status','accept')->first();
        if($wellRequest)
        {
            $this->wellDataService->requestToEdit($request,'published',$wellRequest);
            $wellRequest->delete();
            return response()->json(['message' => 'Survey Well Updated Successfully'], 200);

        }else{
            return response()->json(['message' => 'Request Have been Rejected,Or Something Wrong Happened'], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveDraft(SaveSurveyWellDraftRequest $request)
    {
        try{
            $user_id=Auth::guard('sanctum')->id();
            $draftsSurveyWellCount=SurveyWell::where('user_id',$user_id)
                    ->where(function ($query) {
                        $query->where('published', 'as_draft')
                            ->orWhere('published', 'last_draft');
                    })
                    ->count();
            if(isset($request->survey_well_id)){
                $survey_well=SurveyWell::where('id',$request->survey_well_id)->first();
                if($survey_well && !($survey_well->published=='published')){
                    $this->wellDataService->publishOldWell($request,'as_draft');
                    return response()->json(['message' => 'Well Saved Successfully'], 200);
                }else{
                    return response()->json(['message' => 'didn\'t found this Well,or this well published'], 404);
                }
            }else{
                if($draftsSurveyWellCount>=2){
                    return response()->json(['message' => 'User already has two save_draft test wells.'], 400);
                }else{
                    $this->wellDataService->publishNewWell($request,'as_draft');
                    return response()->json(['message' => 'Survey Well Created Successfully'], 200);
                }
            }
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
