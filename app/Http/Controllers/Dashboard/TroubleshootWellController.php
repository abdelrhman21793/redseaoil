<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\TroubleshootExport;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Troubleshoot;
use App\Models\TroubleshootStructure_description;
use App\Models\TroubleshootWell;
use App\Models\Well;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;

class TroubleshootWellController extends Controller
{
    public $well;
    public function __construct(TroubleshootWell $well)
    {
        $this->well = $well;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wells=$this->well->with('user')->filter($request->query())->paginate(5);
        return view('dashboard.troubleshootwell.index',compact('wells'));
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
    public function deleteTroubleshootWell(string $id)
    {
        $troubleshootWell=TroubleshootWell::find($id);
        if(!$troubleshootWell){
            return redirect()->back()->with('fail','Wrong password please try again');
        }
        return view('dashboard.troubleshootwell.delete',compact('troubleshootWell'));
    }
    public function exportTroubleshoot($troubleshootWellId)
    {
        // Fetch the troubleshoot well by its ID
        $troubleshootWell = TroubleshootWell::findOrFail($troubleshootWellId);

        // Fetch all troubleshoot structure descriptions for the given troubleshoot well
        $troubleshootStructureDescriptions = TroubleshootStructure_description::whereHas('user', function ($query) {
            $query->where('type', 'SUPER_ADMIN');
        })->get();

        // Check if there are any troubleshoot structure descriptions
        if ($troubleshootStructureDescriptions->isEmpty()) {
            // return response()->json(['message' => 'No Troubleshoot structure descriptions found'], 404);
            session()->flash('success', 'No Troubleshoot structure descriptions found');
            return redirect()->back();
        }

        // Initialize the export data array with the headers (troubleshoot structure descriptions)
        $exportData = [$troubleshootStructureDescriptions->pluck('input')->toArray()];

        // Initialize an empty array to hold troubleshoot well data
        $troubleshootWellDataArray = array_fill(0, count($troubleshootStructureDescriptions), null);

        // Fetch all troubleshoot well data for the given troubleshoot well
        $troubleshootWellData = $troubleshootWell->troubleshoot_well_data;

        // Loop through each troubleshoot well data record
        foreach ($troubleshootWellData as $wellData) {
            // Find the index of the corresponding troubleshoot structure description
            $index = $troubleshootStructureDescriptions->search(function ($item) use ($wellData) {
                return $item->id === $wellData->troubleshoot_structure_description_id;
            });

            // If a corresponding troubleshoot structure description is found, add the data to the appropriate column
            if ($index !== false) {
                $troubleshootWellDataArray[$index] = $wellData->data;
            }
        }

        // Add the troubleshoot well data to the export data
        $exportData[] = $troubleshootWellDataArray;

        // Generate Excel file using the export data
        return Excel::download(new TroubleshootExport($exportData), 'troubleshoot_well_'.$troubleshootWellId.'_export.xlsx');
    }
}
