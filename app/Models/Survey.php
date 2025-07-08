<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Survey extends Model
{
    use HasFactory;
    protected $table="surveys";
    protected $fillable=[
        'name'
    ];

    public static function createSurveyWithStruct_StructDesc(Request $request)
    {
        $survey = Survey::create([
            'name'=>$request->surveyName
        ]);
        $structure=SurveyStructure::create([
            'survey_id'=>$survey->id,
            'name'=>$request->structureName
        ]);
        if(isset($request->structuresDes)){
            foreach($request->structuresDes as $type=>$struc){
                if(!empty($struc['input'])){
                    SurveyStructure_description::create([
                        'survey_structure_id'=>$structure->id,
                        'input'=>$struc['input'],
                        'type'=>$struc['type'],
                        'is_require'=>(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional',
                        'view'=>(isset($struc['view']) &&($struc['view'])=='View')?'View':'None',
                        'user_id'=>Auth::id()
                    ]);
                }
            }
        }
        if(isset($request->structuresDesMenu)){
            foreach($request->structuresDesMenu as $type=>$struc){
                if(!empty($struc['input'])){
                    SurveyStructure_description::create([
                        'survey_structure_id'=>$structure->id,
                        'input'=>$struc['input'],
                        'type'=>$struc['type'],
                        'is_require'=>(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional',
                        'view'=>(isset($struc['view']) &&($struc['view'])=='View')?'View':'None',
                        'data'=>(isset($struc['data']))?json_encode($struc['data']):null,
                        'user_id'=>Auth::id()
                    ]);
                }
            }
        }
    }

    public static function createSurveyWithStruct(Request $request)
    {
        $survey=Survey::create([
            'name'=>$request->surveyName
        ]);
        SurveyStructure::create([
            'survey_id'=>$survey->id,
            'name'=>$request->structureName
        ]);
    }

    public static function createSurvey(Request $request)
    {
        Survey::create([
            'name'=>$request->surveyName
        ]);
    }
    public function survey_structures()
    {
        return $this->hasMany(SurveyStructure::class);
    }

}
