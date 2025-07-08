<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\OptionServiceInterface;
use App\Http\Controllers\Interfaces\Front\SurveyServiceInterface;
use App\Models\Option;
use App\Models\Survey;

class SurveyService implements SurveyServiceInterface
{
    public $survey;
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function listSurveys()
    {
        return $this->survey->all();
    }
}
