<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SurveyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id=Auth::guard('sanctum')->id();
        $requests=SurveyRequest::with(['user','survey_well.survey_well_data'])->where('user_id',$user_id)->where('status','Accept')->get();
        if($requests){
            return response()->json($requests, 200);
        }
        return response()->json(['message' => 'Well Not Found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id=Auth::guard('sanctum')->id();
        $created=SurveyRequest::create([
            'user_id'=> $user_id,
            'survey_well_id'=> $request->survey_well_id,
            'description'=>$request->description
        ]);
        if($created){
            return response()->json(['message'=> 'Your Request Created'],200);
        }else{
            return response()->json(['message'=> 'Something Went Wrong'],404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $requests=SurveyRequest::
            where('status','Accept')
            ->with(['user','survey_well.survey_well_data.survey_structure_description.survey_structure.survey'])
            ->find($id);
        if($requests){
            return response()->json($requests, 200);
        }
        return response()->json(['message' => 'Well Not Found,Or Reauest Pending Or Reject'], 404);
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
}
