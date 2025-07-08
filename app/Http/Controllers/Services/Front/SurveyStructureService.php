<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\SurveyStructureServiceInterface;
use App\Models\SurveyStructure;

class SurveyStructureService implements SurveyStructureServiceInterface
{
    public $structure;
    public function __construct(SurveyStructure $structure)
    {
        $this->structure = $structure;
    }
    public function listStructures()
    {
        return $this->structure->all();
    }
}
