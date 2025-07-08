<?php

namespace App\Http\Controllers\Front;

use App\Exports\TestExport;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Test;
use App\Models\TestStructure_description;
use App\Models\TestWell;
use App\Models\TestWell_data;
use App\Models\Well;
use App\Models\Well_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class TestWellController extends Controller
{
    public $well;
    public $well_data;
    public function __construct(TestWell $well,TestWell_data $well_data)
    {
        $this->well=$well;
        $this->well_data=$well_data;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wells = $this->well->where('published', 'published')
                        ->with(['user', 'test_well_data' => function ($query) {
                            $query->whereHas('test_structure_description', function ($subQuery) {
                                $subQuery->where('view', 'View');
                            });
                        }])
                        ->paginate(10);
        if(!$wells){
            return response()->json(['message' => 'test wells Not Found'], 404);
        }
        return response()->json($wells,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $well=$this->well->with(['user','test_well_data'])->findOrFail($id);
        if(!$well){
            return response()->json(['message'=> 'Well Not Found'],404);
        }
        return response()->json($well,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function userWell()
    {
        $user=Auth::guard('sanctum')->user();
        $well=$this->well->where('user_id',$user->id)->get();
        return $well;
    }

    public function exportTest($testWellId)
{
    try {
        // Fetch the test well by its ID
        $testWell = TestWell::findOrFail($testWellId);

        // Fetch all test structure descriptions for the given test well
        $testStructureDescriptions = TestStructure_description::whereHas('user', function ($query) {
            $query->where('type', 'SUPER_ADMIN');
        })->get();

        // Check if there are any test structure descriptions
        if ($testStructureDescriptions->isEmpty()) {
            return response()->json(['message' => 'No test structure descriptions found'], 404);
        }

        // Initialize the export data array with the headers (test structure descriptions)
        $exportData = [$testStructureDescriptions->pluck('input')->toArray()];

        // Initialize an empty array to hold test well data
        $testWellDataArray = array_fill(0, count($testStructureDescriptions), null);

        // Fetch all test well data for the given test well
        $testWellData = $testWell->test_well_data;

        // Loop through each test well data record
        foreach ($testWellData as $wellData) {
            // Find the index of the corresponding test structure description
            $index = $testStructureDescriptions->search(function ($item) use ($wellData) {
                return $item->id === $wellData->test_structure_description_id;
            });

            // If a corresponding test structure description is found, add the data to the appropriate column
            if ($index !== false) {
                $testWellDataArray[$index] = $wellData->data;
            }
        }

        // Add the test well data to the export data
        $exportData[] = $testWellDataArray;

        // Create a new PhpSpreadsheet instance
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Set worksheet title
        $spreadsheet->getActiveSheet()->setTitle('Test Data');

        // Populate spreadsheet with data
        foreach ($exportData as $rowData) {
            $spreadsheet->getActiveSheet()->fromArray($rowData, null, 'A1');
        }

        // Create writer object
        $writer = new Html($spreadsheet);

        // Generate HTML content
        $html = $writer->generateSheetData();

        // Return HTML containing Excel data
        return response($html)->header('Content-Type', 'text/html');
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    public function calcProgress($testWell_id)
    {
        $testWell = TestWell::where('id', $testWell_id)
            ->with(['test_well_data.test_structure_description' => function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('type', 'SUPER_ADMIN');
                });
            }])
            ->with('test_well_data.test_structure_description.test_structure.test')
            ->first();

        $structureDescriptionTestsCount = [];
        $structureDescriptionTestWellCount = [];

        if ($testWell->published == 'as_draft' || $testWell->published == 'last_draft') {
            $tests=Test::with(['test_structures.test_structure_descriptions'=>function ($query){
                        $query->whereHas('user',function($query){
                            $query->where('type','SUPER_ADMIN');
                        });
                    }])->get();
            foreach ($tests as $test) {
                $count = 0;

                foreach ($test->test_structures as $test_structure) {
                    $count += $test_structure->test_structure_descriptions->count();
                }

                $structureDescriptionTestsCount[$test->id] = $count;
            }

            foreach ($testWell->test_well_data as $wellData) {
                $testId = $wellData->test_structure_description->test_structure->test->id;
                if (!isset($structureDescriptionTestWellCount[$testId])) {
                    $structureDescriptionTestWellCount[$testId] = 0;
                }
                $structureDescriptionTestWellCount[$testId]++;
            }

            // Perform calculations
            $result = [];
            foreach ($structureDescriptionTestsCount as $testId => $count) {
                $testCount = $structureDescriptionTestWellCount[$testId] ?? 0;
                $percentage = $count > 0 ? ($testCount / $count) * 100 : 0;
                $result[$testId] = $percentage.'%';
            }
            return response()->json($result,200);
        }
        return response()->json(['message'=>'This Test Well Not Found,Or Published']);

    }
}
