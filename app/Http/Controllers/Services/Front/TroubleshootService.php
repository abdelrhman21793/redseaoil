<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\TroubleshootServiceInterface;
use App\Models\Option;
use App\Models\Troubleshoot;

class TroubleshootService implements TroubleshootServiceInterface
{
    public $troubleshoot;
    public function __construct(Troubleshoot $troubleshoot)
    {
        $this->troubleshoot = $troubleshoot;
    }
    public function listTroubleshoots()
    {
        return $this->troubleshoot->all();
    }
}
