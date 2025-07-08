<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\StructureServiceInterface;
use App\Models\Structure;

class StructureService implements StructureServiceInterface
{
    public $structure;
    public function __construct(Structure $structure)
    {
        $this->structure = $structure;
    }
    public function listStructures()
    {
        return $this->structure->all();
    }
}
