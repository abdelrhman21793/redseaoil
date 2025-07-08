<?php

namespace App\Http\Controllers\Services\Dashboard;
use App\Http\Controllers\Interfaces\Dashboard\StructureServiceInterface;
use App\Models\Structure;
use Illuminate\Support\Facades\DB;
use Throwable;

class StructureService implements StructureServiceInterface
{
    public $structure;
    public function __construct(Structure $structure)
    {
        $this->structure=$structure;
    }

    public function structStore($data)
    {
        $checkDataFill=($data->structureName != '' && $data->option_id!=''
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
