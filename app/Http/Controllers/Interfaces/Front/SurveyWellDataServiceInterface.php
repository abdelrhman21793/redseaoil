<?php

namespace App\Http\Controllers\Interfaces\Front;

interface SurveyWellDataServiceInterface
{
    public function publishNewWell($request,$published);
    public function publishOldWell($request,$published);
    public function requestToEdit($request,$published,$wellRequest);
}
