<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Test extends Model
{
    use HasFactory;
    protected $table="tests";
    protected $fillable=[
        'name'
    ];

    public static function createTestWithStruct_StructDesc(Request $request)
    {
        $test=Test::create([
            'name'=>$request->testName
        ]);
        $structure=TestStructure::create([
            'test_id'=>$test->id,
            'name'=>$request->structureName
        ]);
        if(isset($request->structuresDes)){
            foreach($request->structuresDes as $type=>$struc){
                if(!empty($struc['input'])){
                    TestStructure_description::create([
                        'test_structure_id'=>$structure->id,
                        'input'=>$struc['input'],
                        'type'=>$struc['type'],
                        'is_require'=>(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional',
                        'view'=>(isset($struc['view']) &&($struc['view'])=='View')?'View':'None',
                        'user_id'=>Auth::id()
                    ]);
                }
            }
        }
        if(isset($request->structuresDesMenu)){
            foreach($request->structuresDesMenu as $type=>$struc){
                if(!empty($struc['input'])){
                    TestStructure_description::create([
                        'test_structure_id'=>$structure->id,
                        'input'=>$struc['input'],
                        'type'=>$struc['type'],
                        'is_require'=>(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional',
                        'view'=>(isset($struc['view']) &&($struc['view'])=='View')?'View':'None',
                        'data'=>(isset($struc['data']))?json_encode($struc['data']):null,
                        'user_id'=>Auth::id()
                    ]);
                }
            }
        }
    }

    public static function createTestWithStruct(Request $request)
    {
        $test=Test::create([
            'name'=>$request->testName
        ]);
        TestStructure::create([
            'test_id'=>$test->id,
            'name'=>$request->structureName
        ]);
    }

    public static function createTest(Request $request)
    {
        Test::create([
            'name'=>$request->testName
        ]);
    }
    public function test_structures()
    {
        return $this->hasMany(TestStructure::class);
    }

}
