<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\TestExport;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Test;
use App\Models\TestStructure_description;
use App\Models\TestWell;
use App\Models\Well;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;

class TestWellController extends Controller
{
    public $well;
    public function __construct(TestWell $well)
    {
        $this->well = $well;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wells=$this->well->with('user')->filter($request->query())->paginate(5);
        return view('dashboard.testwell.index',compact('wells'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function deleteTestWell(string $id)
    {
        $testWell=TestWell::find($id);
        if(!$testWell){
            return redirect()->back()->with('fail','Wrong password please try again');
        }
        return view('dashboard.testwell.delete',compact('testWell'));
    }

    public function exportTest($testWellId)
    {
        // Fetch the test well by its ID
        $testWell = TestWell::findOrFail($testWellId);

        // Fetch all test structure descriptions for the given test well
        $testStructureDescriptions = TestStructure_description::whereHas('user', function ($query) {
            $query->where('type', 'SUPER_ADMIN');
        })->get();

        // Check if there are any test structure descriptions
        if ($testStructureDescriptions->isEmpty()) {
            // return response()->json(['message' => 'No test structure descriptions found'], 404);
            session()->flash('success', 'No Test structure descriptions found');
            return redirect()->back();
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

        // Generate Excel file using the export data
        return Excel::download(new TestExport($exportData), 'test_well_'.$testWellId.'_export.xlsx');
    }
}
