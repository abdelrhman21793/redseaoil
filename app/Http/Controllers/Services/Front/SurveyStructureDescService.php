<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\SurveyStructureDescServiceInterface;
use App\Models\Structure_description;
use App\Models\SurveyStructure_description;

class SurveyStructureDescService implements SurveyStructureDescServiceInterface
{
    public $structureDesc;
    public function __construct(SurveyStructure_description $structureDesc)
    {
        $this->structureDesc = $structureDesc;
    }
    public function listStructureDescs()
    {
        return $this->structureDesc->all();
    }
}
