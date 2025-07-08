<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\Front\TestWellDataServiceInterface;
use App\Models\TestRequest;
use App\Http\Requests\PublishTestWellRequest;
use App\Http\Requests\SaveTestWellDraftRequest;
use App\Models\TestStructure;
use App\Models\TestStructure_description;
use App\Models\TestWell;
use App\Models\TestWell_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Throwable;

class TestWellDataController extends Controller
{
    public $well,$well_data,$structure,$structure_description,$wellDataService;
    public function __construct(TestWell $well,TestWell_data $well_data,TestStructure $structure,TestStructure_description $structure_description,TestWellDataServiceInterface $wellDataService)
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


    public function store(PublishTestWellRequest $request)
    {
        try{
            if(isset($request->test_well_id)){
                $this->wellDataService->publishOldWell($request,'published');
                return response()->json(['message' => 'Test Well Created Successfully'], 200);
            }else{
                $this->wellDataService->publishNewWell($request,'published');
                return response()->json(['message' => 'Test Well Created Successfully'], 200);
            }
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(string $id)
    {
        $well=$this->well->with('test_well_data.test_structure_description.test_structure.test')
                ->findOrFail($id);
        if(!$well || $well->published=='published'){
            return response()->json(['message'=> 'this test well is not found,or already published'],404);
        }else{
            return response()->json($well,200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wellRequest=TestRequest::with('test_well.test_well_data')
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function saveDraft(SaveTestWellDraftRequest $request)
    {
        try{
            $user_id=Auth::guard('sanctum')->id();
            $draftsTestWellCount=TestWell::where('user_id',$user_id)
                ->where(function ($query) {
                    $query->where('published', 'as_draft')
                        ->orWhere('published', 'last_draft');
                })
                ->count();

            if(isset($request->test_well_id)){
                $test_well=TestWell::where('id',$request->test_well_id)->first();
                if($test_well && !($test_well->published=='published')){
                    $this->wellDataService->publishOldWell($request,'as_draft');
                    return response()->json(['message' => 'Test Well Saved Successfully'], 200);
                }else{
                    return response()->json(['message' => 'didn\'t found this Test Well,or this Test well published'], 404);
                }
            }else{
                if($draftsTestWellCount>=2){
                    return response()->json(['message' => 'User already has two save_draft test wells.'], 400);
                }else{
                    $this->wellDataService->publishNewWell($request,'as_draft');
                    return response()->json(['message' => 'Test Well Created Successfully'], 200);
                }
            }
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }


}
