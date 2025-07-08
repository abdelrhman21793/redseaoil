<?php

namespace App\Http\Controllers\Interfaces\Dashboard;

interface TroubleshootServiceInterface{
    public function indexTroubleshoot();
    public function troubleshootStore($data);
}
