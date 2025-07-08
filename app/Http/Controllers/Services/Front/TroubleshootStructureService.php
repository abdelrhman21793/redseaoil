<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\StructureServiceInterface;
use App\Http\Controllers\Interfaces\Front\TroubleshootStructureServiceInterface;
use App\Models\Structure;
use App\Models\TroubleshootStructure;

class TroubleshootStructureService implements TroubleshootStructureServiceInterface
{
    public $structure;
    public function __construct(TroubleshootStructure $structure)
    {
        $this->structure = $structure;
    }
    public function listStructures()
    {
        return $this->structure->all();
    }
}
