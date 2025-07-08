<?php

namespace App\Http\Controllers\Interfaces\Dashboard;

interface OptionServiceInterface{
    public function indexOption();
    public function optionStore($data);
}
