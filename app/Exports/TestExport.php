<?php
namespace App\Exports;

use App\Models\TestStructure_description;
use App\Models\TestWell_data;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;

class TestExport implements FromArray
{
    protected $exportData;

    public function __construct($exportData)
    {
        $this->exportData = $exportData;
    }

    public function array(): array
    {
        return $this->exportData;
    }
}
