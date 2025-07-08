<?php

namespace App\Http\Controllers\Services\Dashboard;

use App\Http\Controllers\Interfaces\Dashboard\StructureDescServiceInterface;
use App\Models\Structure;
use Illuminate\Support\Facades\DB;
use Throwable;

class StructureDescService implements StructureDescServiceInterface
{
    public $structure;
    public function __construct(Structure $structure)
    {
        $this->structure=$structure;
    }
    public function structDescUpdate($data,$id)
    {
        if(!isset($data->structuresDesMenu) && !isset($data->structuresDes )){
            $this->structure->UpdateStrucDesc($data,$id);
        }elseif(isset($data->structuresDes) || isset($data->structuresDesMenu)){
            $this->structure->createDesc_Menu($data,$id);
        }
    }

}
