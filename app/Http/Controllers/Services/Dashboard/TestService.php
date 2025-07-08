<?php

namespace App\Http\Controllers\Services\Dashboard;

use App\Http\Controllers\Interfaces\Dashboard\TestServiceInterface;
use App\Models\Structure;
use App\Models\Test;
use App\Models\TestStructure;
use Illuminate\Support\Facades\DB;
use Throwable;

class TestService implements TestServiceInterface
{
    public $test;
    public $structure;
    public function __construct(Test $test,TestStructure $structure)
    {
        $this->test=$test;
        $this->structure=$structure;
    }
    public function indexTest()
    {
        return $this->test->with('test_structures')->paginate('5');
    }
    public function testStore($data)
    {
        DB::beginTransaction();
        try{
            if($data->structureName != '' && (is_array($data->structuresDes )
                || is_array($data->structuresDesMenu)) && (!empty($data->structuresDes) || !empty($data->structuresDesMenu))){
                $this->test->createTestWithStruct_StructDesc($data);
            }elseif($data->structureName != '' && (is_null($data->structuresDes) || empty($data->structuresDes))){
                $this->test->createTestWithStruct($data);
            }
            DB::commit();
        }catch(Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

}
