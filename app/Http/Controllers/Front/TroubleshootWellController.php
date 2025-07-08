<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Troubleshoot;
use App\Models\TroubleshootWell;
use App\Models\TroubleshootWell_data;
use App\Models\Well;
use App\Models\Well_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
class TroubleshootWellController extends Controller
{
    public $well;
    public $well_data;
    public function __construct(TroubleshootWell $well,TroubleshootWell_data $well_data)
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
                        ->with(['user', 'troubleshoot_well_data' => function ($query) {
                            $query->whereHas('troubleshoot_structure_description', function ($subQuery) {
                                $subQuery->where('view', 'View');
                            });
                        }])
                        ->paginate(10);
        if(!$wells){
            return response()->json(['message' => 'troubleshoot wells Not Found'], 404);
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
        $well=$this->well->with(['user','troubleshoot_well_data'])->findOrFail($id);
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

    public function generatePDF(string $id)
    {
        $options = Troubleshoot::all();
        $well = $this->well->with('troubleshoot_structure_descriptions')->find($id);

        $data = [
            'well' => $well,
            'structureDescriptions' => $well->troubleshoot_structure_descriptions,
            'options' => $options
        ];

        $htmlContent = View::make('dashboard.well.well_pdf', $data)->render();

        // You can store the HTML content as a temporary file or in a database
        // For simplicity, we'll store it in a temporary file in the public directory
        $fileName = 'temp_pdf_' . uniqid() . '.html';
        $filePath = public_path($fileName);
        file_put_contents($filePath, $htmlContent);

        // Return JSON response with HTML content and URL
        return response()->json([
            // 'html' => $htmlContent,
            'url' => url($fileName), // This is the URL to access the temporary HTML file
        ]);
    }
    public function calcProgress($troubleshootWell_id)
    {
        $troubleshootWell = TroubleshootWell::where('id', $troubleshootWell_id)
            ->with(['troubleshoot_well_data.troubleshoot_structure_description' => function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('type', 'SUPER_ADMIN');
                });
            }])
            ->with('troubleshoot_well_data.troubleshoot_structure_description.troubleshoot_structure.troubleshoot')
            ->first();

        $structureDescriptionTroubleshootsCount = [];
        $structureDescriptionTroubleshootWellCount = [];

        if ($troubleshootWell && ($troubleshootWell->published == 'as_draft' || $troubleshootWell->published == 'last_draft')) {
            $troubleshoots=Troubleshoot::with(['troubleshoot_structures.troubleshoot_structure_descriptions'=>function ($query){
                        $query->whereHas('user',function($query){
                            $query->where('type','SUPER_ADMIN');
                        });
                    }])->get();
            foreach ($troubleshoots as $troubleshoot) {
                $count = 0;

                foreach ($troubleshoot->troubleshoot_structures as $troubleshoot_structure) {
                    $count += $troubleshoot_structure->troubleshoot_structure_descriptions->count();
                }

                $structureDescriptionTroubleshootsCount[$troubleshoot->id] = $count;
            }

            foreach ($troubleshootWell->troubleshoot_well_data as $wellData) {
                $troubleshootId = $wellData->troubleshoot_structure_description->troubleshoot_structure->troubleshoot->id;
                if (!isset($structureDescriptionTroubleshootWellCount[$troubleshootId])) {
                    $structureDescriptionTroubleshootWellCount[$troubleshootId] = 0;
                }
                $structureDescriptionTroubleshootWellCount[$troubleshootId]++;
            }

            // Perform calculations
            $result = [];
            foreach ($structureDescriptionTroubleshootsCount as $troubleshootId => $count) {
                $testCount = $structureDescriptionTroubleshootWellCount[$troubleshootId] ?? 0;
                $percentage = $count > 0 ? ($testCount / $count) * 100 : 0;
                $result[$troubleshootId] = $percentage.'%';
            }
            return response()->json($result,200);
        }
        return response()->json(['message'=>'This Troubleshoot Well Not Found,Or Published']);
    }
}
