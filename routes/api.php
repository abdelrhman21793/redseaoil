<?php

use App\Http\Controllers\Api\AccessTokenController;
use App\Http\Controllers\Front\OptionController;
use App\Http\Controllers\Front\RequestController;
use App\Http\Controllers\Front\SurveyController;
use App\Http\Controllers\Front\SurveyRequestController;
use App\Http\Controllers\Front\SurveyWellController;
use App\Http\Controllers\Front\SurveyWellDataController;
use App\Http\Controllers\Front\TestController;
use App\Http\Controllers\Front\TestRequestController;
use App\Http\Controllers\Front\TestWellController;
use App\Http\Controllers\Front\TestWellDataController;
use App\Http\Controllers\Front\TroubleshootController;
use App\Http\Controllers\Front\TroubleshootRequestController;
use App\Http\Controllers\Front\TroubleshootWellController;
use App\Http\Controllers\Front\TroubleshootWellDataController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\WellController;
use App\Http\Controllers\Front\WellDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('auth/access-tokens',[AccessTokenController::class,'store'])
    ->middleware('guest:sanctum');

Route::group(['middleware'=>'auth:sanctum'],function(){
    // Route::get('/user',function (){
    //     return Auth::guard('sanctum')->user();
    // });

    Route::get('users',[UserController::class,'index']);

    Route::delete('auth/access-tokens/{token?}',[AccessTokenController::class,'destroy']);

    Route::get('options',[OptionController::class,'index']);
    Route::get('surveys',[SurveyController::class,'index']);
    Route::get('tests',[TestController::class,'index']);
    Route::get('troubleshoots',[TroubleshootController::class,'index']);


    Route::post('wellsData/saveDraft',[WellDataController::class,'saveDraft']);


    Route::apiResource('wellsData',WellDataController::class);
    Route::apiResource('survey-welldata',SurveyWellDataController::class);
    Route::apiResource('test-welldata',TestWellDataController::class);
    Route::apiResource('troubleshoot-welldata',TroubleshootWellDataController::class);



    Route::get('wells/userWells',[WellController::class,'userWell']);
    Route::get('wells/userSurveyWells',[SurveyWellController::class,'userWell']);
    Route::get('wells/userTestWells',[TestWellController::class,'userWell']);
    Route::get('wells/userTroubleshootWells',[TroubleshootWellController::class,'userWell']);

    Route::get('wells/generatePDF/{id}',[WellController::class,'generatePDF']);
    Route::get('surveywells/generatePDF/{id}',[SurveyWellController::class,'generatePDF']);
    Route::get('testwells/generateEXCEl/{id}',[TestWellController::class,'exportTest']);
    // Route::get('testwells/generatePDF/{id}',[TestWellController::class,'generatePDF']);
    // Route::get('troubleshootwells/generatePDF/{id}',[TroubleshootWellController::class,'generatePDF']);

    Route::get('wells/calcProgress/{id}',[WellController::class,'calcProgress']);
    Route::get('surveywells/calcProgress/{id}',[SurveyWellController::class,'calcProgress']);
    Route::get('testwells/calcProgress/{id}',[TestWellController::class,'calcProgress']);
    Route::get('troubleshootwells/calcProgress/{id}',[TroubleshootWellController::class,'calcProgress']);

    Route::apiResource('wells',WellController::class);
    Route::apiResource('surveywells',SurveyWellController::class);
    Route::apiResource('testwells',TestWellController::class);
    Route::apiResource('troubleshootwells',TroubleshootWellController::class);

    Route::post('survey-welldata/saveDraft',[SurveyWellDataController::class,'saveDraft']);
    Route::apiResource('survey-welldata',SurveyWellDataController::class);

    Route::post('test-welldata/saveDraft',[TestWellDataController::class,'saveDraft']);
    Route::apiResource('test-welldata',TestWellDataController::class);

    Route::post('troubleshoot-welldata/saveDraft',[TroubleshootWellDataController::class,'saveDraft']);
    Route::apiResource('troubleshoot-welldata',TroubleshootWellDataController::class);

    Route::apiResource('requests',RequestController::class);
    Route::apiResource('test-requests',TestRequestController::class);
    Route::apiResource('troubleshoot-requests',TroubleshootRequestController::class);
    Route::apiResource('survey-requests',SurveyRequestController::class);

});
