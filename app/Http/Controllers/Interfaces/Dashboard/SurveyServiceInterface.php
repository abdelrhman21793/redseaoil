<?php

namespace App\Http\Controllers\Interfaces\Dashboard;

interface SurveyServiceInterface{
    public function indexSurvey();
    public function surveyStore($data);
}
