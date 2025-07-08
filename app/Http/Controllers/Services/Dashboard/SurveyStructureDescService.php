<?php

namespace App\Http\Controllers\Services\Dashboard;

use App\Http\Controllers\Interfaces\Dashboard\StructureDescServiceInterface;

use App\Http\Controllers\Interfaces\Dashboard\SurveyStructureDescServiceInterface;
use App\Models\Structure;
use App\Models\SurveyStructure;
use Illuminate\Support\Facades\DB;
use Throwable;


class SurveyStructureDescService implements SurveyStructureDescServiceInterface
{
    public $structure;
    public function __construct(SurveyStructure $structure)
    {
        $this->structure=$structure;
    }
    public function structDescUpdate($data,$id)
    {
        if(!isset($data->structuresDesMenu) && !isset($data->structuresDes )){
            $this->structure->UpdateStrucDesc($data,$id);
        }elseif(isset($data->structuresDes) || isset($data->structuresDesMenu)){
            $this->structure->createDesc_Menu($data,$id);
        }
    }

}
