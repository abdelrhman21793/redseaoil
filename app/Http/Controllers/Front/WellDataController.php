<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Front\WellDataServiceInterface;
use App\Http\Requests\PublishWellRequest;
use App\Http\Requests\SaveDraftRequest;
use App\Http\Requests\WellDataRequest;
use App\Models\Request as ModelsRequest;
use App\Models\Structure;
use App\Models\Structure_description;
use App\Models\Well;
use App\Models\Well_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class WellDataController extends Controller
{
    public $well,$well_data,$structure,$structure_description,$wellDataService;
    public function __construct(Well $well,Well_data $well_data,Structure $structure,Structure_description $structure_description,WellDataServiceInterface $wellDataService)
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

    public function store(PublishWellRequest $request)
    {
        try{
            if(isset($request->well_id)){
                $well=Well::where('id',$request->well_id)->first();
                if($well){
                    $this->wellDataService->publishOldWell($request,'published');
                    return response()->json(['message' => 'Well Created Successfully'], 200);
                }else{
                    return response()->json(['message' => 'This Well didn\'t found'], 200);
                }
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
        $well=$this->well->with('well_data.Structure_description.structure.option')
                    ->findOrFail($id);
        if(!$well || $well->published=='published'){
            return response()->json(['message'=> 'this well is not found,or already published'],404);
        }else{
            return response()->json($well,200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wellRequest=ModelsRequest::with('well.well_data')
            ->where('id',$id)
            ->where('status','accept')
            ->first();
        if($wellRequest)
        {
            $this->wellDataService->requestToEdit($request,'published',$wellRequest);
            $wellRequest->delete();
            return response()->json(['message' => 'Well Updated Successfully'], 200);
        }else{
            return response()->json(['message' => 'Request Have been Rejected,Or Something Wrong Happened'], 200);
        }
        // return $wellRequest;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function saveDraft(SaveDraftRequest $request)
    {
        try{
            $user_id=Auth::guard('sanctum')->id();
            $draftsWellCount=Well::where('user_id',$user_id)
                ->where(function ($query) {
                    $query->where('published', 'as_draft')
                          ->orWhere('published', 'last_draft');
                })
                ->count();
            if(isset($request->well_id)){
                $well=Well::where('id',$request->well_id)->first();
                if($well && !($well->published=='published')){
                    $this->wellDataService->publishOldWell($request,'last_draft');
                    return response()->json(['message' => 'Well Saved Successfully'], 200);
                }else{
                    return response()->json(['message' => 'didn\'t found this Well,or this well published'], 404);
                }
            }else{
                if($draftsWellCount>=2){
                    return response()->json(['message' => 'User already has two save_draft wells.'], 400);
                }else{
                    $this->wellDataService->publishNewWell($request,'as_draft');
                    return response()->json(['message' => 'Well Saved Successfully'], 200);
                }
            }
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
