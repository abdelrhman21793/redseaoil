<?php

namespace App\Http\Controllers\Services\Dashboard;

use App\Http\Controllers\Interfaces\Dashboard\SurveyServiceInterface;
use App\Models\Option;
use App\Models\Structure;
use App\Models\Survey;
use App\Models\SurveyStructure;
use Illuminate\Support\Facades\DB;
use Throwable;

class SurveyService implements SurveyServiceInterface
{
    public $survey;
    public $structure;
    public function __construct(Survey $survey,SurveyStructure $structure)
    {
        $this->survey=$survey;
        $this->structure=$structure;
    }
    public function indexSurvey()
    {
        return $this->survey->with('survey_structures')->paginate('5');
    }
    public function surveyStore($data)
    {
        DB::beginTransaction();
        try{
            if($data->structureName != '' && (is_array($data->structuresDes )
                || is_array($data->structuresDesMenu)) && (!empty($data->structuresDes) || !empty($data->structuresDesMenu))){
                $this->survey->createSurveyWithStruct_StructDesc($data);
            }elseif($data->structureName != '' && (is_null($data->structuresDes) || empty($data->structuresDes))){
                $this->survey->createSurveyWithStruct($data);
            }
            DB::commit();
        }catch(Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

}
