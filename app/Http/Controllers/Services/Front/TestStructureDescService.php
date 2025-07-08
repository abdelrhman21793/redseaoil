<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\StructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Front\TestStructureDescServiceInterface;
use App\Models\Structure_description;
use App\Models\TestStructure_description;

class TestStructureDescService implements TestStructureDescServiceInterface
{
    public $structureDesc;
    public function __construct(TestStructure_description $structureDesc)
    {
        $this->structureDesc = $structureDesc;
    }
    public function listStructureDescs()
    {
        return $this->structureDesc->all();
    }
}
