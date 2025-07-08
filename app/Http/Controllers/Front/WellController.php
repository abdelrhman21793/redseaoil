<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Structure_description;
use App\Models\Well;
use App\Models\Well_data;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
class WellController extends Controller
{
    public $well;
    public $well_data;
    public function __construct(Well $well,Well_data $well_data)
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
                        ->with(['user', 'well_data' => function ($query) {
                            $query->whereHas('Structure_description', function ($subQuery) {
                                $subQuery->where('view', 'View');
                            })->with('Structure_description');
                        }])
                        ->paginate(10);

        if(!$wells){
            return response()->json(['message' => 'Well Not Found'], 404);
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
        $well=$this->well->with(['user','well_data'])->findOrFail($id);
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
        $well=$this->well->where('published','as_draft')->orWhere('published','last_draft')->where('user_id',$user->id)->get();
        return $well;
    }


    public function generatePDF(string $id)
    {
        $options = Option::all();
        $well = $this->well->with('Structure_descriptions')->find($id);

        $data = [
            'well' => $well,
            'structureDescriptions' => $well->Structure_descriptions,
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

    public function calcProgress($well_id)
    {
        $well = Well::where('id', $well_id)
            ->with(['well_data.Structure_description' => function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('type', 'SUPER_ADMIN');
                });
            }])
            ->with('well_data.Structure_description.structure.option')
            ->first();

        $structureDescriptionOptionsCount = [];
        $structureDescriptionWellCount = [];

        if ($well->published == 'as_draft' || $well->published == 'last_draft') {
            $options=Option::with(['structures.structure_descriptions'=>function ($query){
                        $query->whereHas('user',function($query){
                            $query->where('type','SUPER_ADMIN');
                        });
                    }])->get();
            foreach ($options as $option) {
                $count = 0;

                foreach ($option->structures as $structure) {
                    $count += $structure->structure_descriptions->count();
                }

                $structureDescriptionOptionsCount[$option->id] = $count;
            }

            foreach ($well->well_data as $wellData) {
                $optionId = $wellData->structure_description->structure->option->id;
                if (!isset($structureDescriptionWellCount[$optionId])) {
                    $structureDescriptionWellCount[$optionId] = 0;
                }
                $structureDescriptionWellCount[$optionId]++;
            }

            // Perform calculations
            $result = [];
            foreach ($structureDescriptionOptionsCount as $optionId => $count) {
                $optionCount = $structureDescriptionWellCount[$optionId] ?? 0;
                $percentage = $count > 0 ? ($optionCount / $count) * 100 : 0;
                $result[$optionId] = ($percentage>100)?'100%':$percentage.'%';
            }
            return response()->json($result,200);
        }
        return response()->json(['message'=>'This Well Not Found,Or Published']);

    }
}
