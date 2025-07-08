<?php

namespace App\Exports;

use App\Models\TroubleshootStructure_description;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;


class TroubleshootExport implements FromArray
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
