<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\TestStructureServiceInterface;
use App\Models\TestStructure;

class TestStructureService implements TestStructureServiceInterface
{
    public $structure;
    public function __construct(TestStructure $structure)
    {
        $this->structure = $structure;
    }
    public function listStructures()
    {
        return $this->structure->all();
    }
}
