<?php

namespace App\Http\Controllers\Services\Dashboard;
use App\Http\Controllers\Interfaces\Dashboard\StructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TroubleshootStructureServiceInterface;
use App\Models\Structure;
use App\Models\TroubleshootStructure;
use Illuminate\Support\Facades\DB;
use Throwable;

class TroubleshootStructureService implements TroubleshootStructureServiceInterface
{
    public $structure;
    public function __construct(TroubleshootStructure $structure)
    {
        $this->structure=$structure;
    }

    public function structStore($data)
    {
        $checkDataFill=($data->structureName != '' && $data->troubleshoot_id!=''
                            && (is_array($data->structuresDes ) || is_array($data->structuresDesMenu))
                            && (!empty($data->structuresDes) || !empty($data->structuresDesMenu)));
        DB::beginTransaction();
        try{
            if($checkDataFill){
                $this->structure->createStruct_Desc_menu($data);
            }else{
                $this->structure->createStruct($data);
            }
            DB::commit();
        }catch(Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

}
