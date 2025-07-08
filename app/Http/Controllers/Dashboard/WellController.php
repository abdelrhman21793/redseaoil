<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Well;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class WellController extends Controller
{
    public $well;
    public function __construct(Well $well)
    {
        $this->well = $well;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wells=$this->well->with('user')->filter($request->query())->paginate(5);
        return view('dashboard.well.index',compact('wells'));
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
    public function deleteWell(string $id)
    {
        $well=Well::find($id);
        if(!$well){
            return redirect()->back()->with('fail','Wrong password please try again');
        }
        return view('dashboard.well.delete',compact('well'));
    }
    public function generatePDF($id)
    {
        $options=Option::with(['structures.structure_descriptions'=> function ($query) use ($id){
            $query->whereHas('user', function ($query) {
                $query->where('type', 'SUPER_ADMIN');
            })->orWhere('well_id',$id);
        }])->get();

        $well = $this->well->with('Structure_descriptions')->find($id);

        $data=[
            'well'=>$well,
            'structureDescriptions'=>$well->Structure_descriptions,
            'options'=>$options
        ];

        return view('dashboard.well.pdf')->with($data);
    }
}
