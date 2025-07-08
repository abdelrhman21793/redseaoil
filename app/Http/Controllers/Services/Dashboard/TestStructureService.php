<?php

namespace App\Http\Controllers\Services\Dashboard;
use App\Http\Controllers\Interfaces\Dashboard\StructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TestStructureServiceInterface;
use App\Models\Structure;
use App\Models\TestStructure;
use Illuminate\Support\Facades\DB;
use Throwable;

class TestStructureService implements TestStructureServiceInterface
{
    public $structure;
    public function __construct(TestStructure $structure)
    {
        $this->structure=$structure;
    }

    public function structStore($data)
    {
        $checkDataFill=($data->structureName != '' && $data->test_id!=''
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
