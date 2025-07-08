<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Front\TroubleshootServiceInterface;
use App\Http\Controllers\Services\Front\TroubleshootWellDataService;
use App\Http\Requests\PublishTroubleshootWellRequest;
use App\Http\Requests\SaveTroubleshootWellDraftRequest;
use App\Models\TroubleshootRequest;
use App\Models\TroubleshootStructure;
use App\Models\TroubleshootStructure_description;
use App\Models\TroubleshootWell;
use App\Models\TroubleshootWell_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class TroubleshootWellDataController extends Controller
{
    public $well,$well_data,$structure,$structure_description,$wellDataService;
    public function __construct(TroubleshootWell $well,TroubleshootWell_data $well_data,TroubleshootStructure $structure,
            TroubleshootStructure_description $structure_description,TroubleshootWellDataService $wellDataService)
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

    public function store(PublishTroubleshootWellRequest $request)
    {
        try{
            if(isset($request->troubleshoot_well_id)){
                $this->wellDataService->publishOldWell($request,'published');
                return response()->json(['message' => 'Well Created Successfully'], 200);
            }else{
                $this->wellDataService->publishNewWell($request,'published');
                return response()->json(['message' => 'Well Created Successfully'], 200);
            }
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(string $id)
    {
        $well=$this->well->with('troubleshoot_well_data.troubleshoot_structure_description.troubleshoot_structure.troubleshoot')
                ->findOrFail($id);
        if(!$well || $well->published=='published'){
            return response()->json(['message'=> 'this troubleshoot well is not found,or already published'],404);
        }else{
            return response()->json($well,200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wellRequest=TroubleshootRequest::with('troubleshoot_well.troubleshoot_well_data')->where('id',$id)->where('status','accept')->first();
        if($wellRequest)
        {
            $this->wellDataService->requestToEdit($request,'published',$wellRequest);
            $wellRequest->delete();
            return response()->json(['message' => 'Well Updated Successfully'], 200);
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

    public function saveDraft(SaveTroubleshootWellDraftRequest $request)
    {
        try{
            $user_id=Auth::guard('sanctum')->id();
            $draftsWellCount=TroubleshootWell::where('user_id',$user_id)
                ->where(function ($query) {
                    $query->where('published', 'as_draft')
                        ->orWhere('published', 'last_draft');
                })
                ->count();
            if(isset($request->troubleshoot_well_id)){
                $troubleshoot=TroubleshootWell::where('id',$request->troubleshoot_well_id)->first();
                if($troubleshoot && !($troubleshoot->published=='published')){
                    $this->wellDataService->publishOldWell($request,'as_draft');
                    return response()->json(['message' => 'Troubleshoot Well Saved Successfully'], 200);
                }else{
                    return response()->json(['message' => 'didn\'t found this Troubleshoot Well,or this Troubleshoot well published'], 404);
                }
            }else{
                if($draftsWellCount>=2){
                    return response()->json(['message' => 'User already has two save_draft wells.'], 400);
                }else{
                    $this->wellDataService->publishNewWell($request,'as_draft');
                    return response()->json(['message' => 'Troubleshoot Well Created Successfully'], 200);
                }
            }
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
