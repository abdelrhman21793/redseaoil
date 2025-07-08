<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\RequestController;
use App\Http\Controllers\Dashboard\StructureController;
use App\Http\Controllers\Dashboard\StructureDescController;
use App\Http\Controllers\Dashboard\SurveyController;
use App\Http\Controllers\Dashboard\SurveyStructureController;
use App\Http\Controllers\Dashboard\SurveyWellController;
use App\Http\Controllers\Dashboard\TestController;
use App\Http\Controllers\Dashboard\TestStructureController;
use App\Http\Controllers\Dashboard\TestWellController;
use App\Http\Controllers\Dashboard\TroubleshootController;
use App\Http\Controllers\Dashboard\TroubleshootStructureController;
use App\Http\Controllers\Dashboard\SurveyRequestController;
use App\Http\Controllers\Dashboard\SurveyStructureDescController;
use App\Http\Controllers\Dashboard\TestRequestController;
use App\Http\Controllers\Dashboard\TestStructureDescController;
use App\Http\Controllers\Dashboard\TroubleshootRequestController;
use App\Http\Controllers\Dashboard\TroubleshootStructureDescController;
use App\Http\Controllers\Dashboard\TroubleshootWellController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WellController;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware'=>'auth:sanctum',config('jetstream.auth_session'),'verified'],function(){
        Route::get('/',[DashboardController::class,'index'])
            ->name('dashboard');
        Route::resource('/users',UserController::class);


        Route::post('/update-structure-order/{structure}', function(Request $request,Structure $structure){
            $structure->update(['order' => $request->newPosition]);
        })->name('update-structure-order');


        //Routes for (Option, Survey, Test, Troubleshoot)
        Route::resource('/optionStructures',OptionController::class)->only(['index','create','store'])
            ->middleware('check.super');
        Route::get('/optionStructures/delete/{id}',[OptionController::class,'deleteOption'])
            ->name('optionStructures.delete');

        Route::resource('/surveys',SurveyController::class)->only(['index','create','store'])
            ->middleware('check.super');
        Route::get('/survey/delete/{id}',[SurveyController::class,'deleteSurvey'])
            ->name('survey.delete');

        Route::resource('/tests',TestController::class)->only(['index','create','store'])
            ->middleware('check.super');
        Route::get('/test/delete/{id}',[TestController::class,'deleteTest'])
            ->name('test.delete');

        Route::resource('/troubleshoots',TroubleshootController::class)->only(['index','create','store'])
            ->middleware('check.super');
        Route::get('/troubleshoot/delete/{id}',[TroubleshootController::class,'deleteTroubleshoot'])
            ->name('troubleshoot.delete');


        //Routes for (OptionStructure, SurveyStructure, TestStructure, TroubleshootStructure) and (OptionStructureDesc, SurveyStructureDesc, TestStructureDesc, TroubleshootStructureDesc)
        Route::resource('/structures',StructureController::class)->only(['create','store','show']);
        Route::get('/structuresDesc/delete/{id}',[StructureController::class,'deleteStruct'])
            ->name('structures.delete');
        Route::post('/structures/selectedStrctures',[StructureController::class,'selectedDesc'])
            ->name('structures.selectedDesc');
        Route::post('/structures/deleteSelectedStrctures',[StructureController::class,'deleteSelectedDesc'])
            ->name('structures.deleteSelectedDesc');

        Route::resource('/surveystructures',SurveyStructureController::class)->only(['create','store','show']);
        Route::get('/surveyStructuresDesc/delete/{id}',[SurveyStructureController::class,'deleteStruct'])
            ->name('surveyStructure.delete');
        Route::post('/surveystructures/selectedStrctures',[SurveyStructureController::class,'selectedDesc'])
            ->name('surveystructures.selectedDesc');
        Route::post('/surveystructures/deleteSelectedStrctures',[SurveyStructureController::class,'deleteSelectedDesc'])
            ->name('surveystructures.deleteSelectedDesc');

        Route::resource('/teststructures',TestStructureController::class)->only(['create','store','show']);
        Route::get('/testStructuresDesc/delete/{id}',[TestStructureController::class,'deleteStruct'])
            ->name('testStructure.delete');
        Route::post('/teststructures/selectedStrctures',[TestStructureController::class,'selectedDesc'])
            ->name('teststructures.selectedDesc');
        Route::post('/teststructures/deleteSelectedStrctures',[TestStructureController::class,'deleteSelectedDesc'])
            ->name('teststructures.deleteSelectedDesc');

        Route::resource('/troubleshootstructures',TroubleshootStructureController::class)->only(['create','store','show']);
        Route::get('/troubleshootStructuresDesc/delete/{id}',[TroubleshootStructureController::class,'deleteStruct'])
            ->name('troubleshootStructure.delete');
        Route::post('/troubleshootstructures/selectedStrctures',[TroubleshootStructureController::class,'selectedDesc'])
            ->name('troubleshootstructures.selectedDesc');
        Route::post('/troubleshootstructures/deleteSelectedStrctures',[TroubleshootStructureController::class,'deleteSelectedDesc'])
            ->name('troubleshootstructures.deleteSelectedDesc');

        Route::resource('/structuresDesc',StructureDescController::class)->only(['edit','update']);
        Route::get('/structureDescription/delete/{id}',[StructureDescController::class,'deleteStructDesc'])
            ->name('deleteStructDesc');

        Route::resource('/surveystructuresdesc',SurveyStructureDescController::class)->only(['edit','update']);
        Route::get('/surveystructureDescription/delete/{id}',[SurveyStructureDescController::class,'deleteStructDesc'])
            ->name('surveydesc.delete');

        Route::resource('/teststructuresdesc',TestStructureDescController::class)->only(['edit','update']);
        Route::get('/teststructureDescription/delete/{id}',[TestStructureDescController::class,'deleteStructDesc'])
            ->name('testdesc.delete');

        Route::resource('/troubleshootstructuresdesc',TroubleshootStructureDescController::class)->only(['edit','update']);
        Route::get('/troubleshootstructureDescription/delete/{id}',[TroubleshootStructureDescController::class,'deleteStructDesc'])
            ->name('troubleshootdesc.delete');


        //Routes for (Well, SurveyWell, TestWell, TroubleshootWell) & Their PDFs
        Route::resource('/wells',WellController::class);


        Route::resource('/surveywells',SurveyWellController::class);


        Route::resource('/testwells',TestWellController::class);
        Route::get('testwells/export/{testId}', [TestWellController::class,'exportTest'])->name('export.test');


        Route::resource('/troubleshootwells',TroubleshootWellController::class);
        Route::get('troubleshootwells/export/{troubleshootId}', [TroubleshootWellController::class,'exportTroubleshoot'])
            ->name('export.troubleshoot');



        //Routes for (Request, SurveyRequest, TestRequest, TroubleshootRequest)
        Route::resource('/requests',RequestController::class);
        Route::match(['get','post'],'/requests/reject/{id}',[RequestController::class,'reject'])
            ->name('requests.reject');

        Route::resource('/surveyrequests',SurveyRequestController::class);
        Route::match(['get','post'],'/survey/requests/reject/{id}',[SurveyRequestController::class,'reject'])
            ->name('surveyrequests.reject');

        Route::resource('/testrequests',TestRequestController::class);
        Route::match(['get','post'],'/test/requests/reject/{id}',[TestRequestController::class,'reject'])
            ->name('testrequests.reject');

        Route::resource('/troubleshootrequests',TroubleshootRequestController::class);
        Route::match(['get','post'],'/troubleshoot/requests/reject/{id}',[TroubleshootRequestController::class,'reject'])
            ->name('troubleshootrequests.reject');
        Route::get('wells/generatePDF/{id}',[WellController::class,'generatePDF'])
            ->name('wells.generatePDF');

        Route::get('wells/delete/{id}',[WellController::class,'deleteWell'])
            ->name('wells.delete');

        Route::get('surveywells/delete/{id}',[SurveyWellController::class,'deleteSurveyWell'])
            ->name('surveywells.delete');

        Route::get('testwells/delete/{id}',[TestWellController::class,'deleteTestWell'])
            ->name('testwells.delete');

        Route::get('troubleshootwells/delete/{id}',[TroubleshootWellController::class,'deleteTroubleshootWell'])
            ->name('troubleshootwells.delete');

        Route::get('surveywells/generatePDF/{id}',[SurveyWellController::class,'generatePDF'])
            ->name('surveywells.generatePDF');
});
