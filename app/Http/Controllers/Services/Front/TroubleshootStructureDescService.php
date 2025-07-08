<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\StructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Front\TroubleshootStructureDescServiceInterface;
use App\Models\Structure_description;
use App\Models\TroubleshootStructure_description;

class TroubleshootStructureDescService implements TroubleshootStructureDescServiceInterface
{
    public $structureDesc;
    public function __construct(TroubleshootStructure_description $structureDesc)
    {
        $this->structureDesc = $structureDesc;
    }
    public function listStructureDescs()
    {
        return $this->structureDesc->all();
    }
}
