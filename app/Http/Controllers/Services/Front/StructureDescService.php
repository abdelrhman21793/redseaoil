<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\StructureDescServiceInterface;
use App\Models\Structure_description;

class StructureDescService implements StructureDescServiceInterface
{
    public $structureDesc;
    public function __construct(Structure_description $structureDesc)
    {
        $this->structureDesc = $structureDesc;
    }
    public function listStructureDescs()
    {
        return $this->structureDesc->all();
    }
}
