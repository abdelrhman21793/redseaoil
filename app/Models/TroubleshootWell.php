<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TroubleshootWell extends Model
{
    use HasFactory;
    protected $table='troubleshoot_wells';
    protected $fillable=[
        'well_id','name','from','to','well','rig','images','user_id','published'
    ];
    public function well()
    {
        return $this->belongsTo(Well::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function troubleshoot_structure_descriptions()
    {
        return $this->belongsToMany(TroubleshootStructure_description::class
            ,'troubleshoot_well_data','troubleshoot_well_id','troubleshoot_struct_desc_id')
            ->withPivot(['data'])
            ->using(TroubleshootWell_data::class);
    }

    public function troubleshoot_well_data()
    {
        return $this->hasMany(TroubleshootWell_data::class);
    }

    public static function createWell($request,$published)
    {
        $images = $request->file('images');
        $imagePaths = [];
        if(isset($images)){
            foreach ($images as $image) {
                $newName = rand() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('upload/images', $newName, 'public'); // Store the image using Storage facade
                $imagePaths[] = $path;
            }
        }
        $well=TroubleshootWell::create([
            'well_id'=>$request->well_id,
            'name' => $request->name,
            'from' => $request->from,
            'to' => $request->to,
            'user_id' => Auth::guard('sanctum')->id(),
            'images' => json_encode($imagePaths),
            'published' => ($published == 'published') ? 'published' : 'as_draft',

        ]);
        return $well;
    }

    public static function updateWell($well,$request,$published)
    {
        $allImagePaths = [];

        if ($request->hasFile('images')) {
            // Process the uploaded images
            $newImages = $request->file('images');
            $newImagePaths = [];

            foreach ($newImages as $newImage) {
                $newName = rand() . '.' . $newImage->getClientOriginalExtension();
                $path = $newImage->storeAs('upload/images', $newName, 'public');
                $newImagePaths[] = $path;
            }

            // Merge old and new image paths
            $oldImagePaths = json_decode($well->images, true) ?? [];
            $allImagePaths = array_merge($oldImagePaths, $newImagePaths);
        }
        $well->update([
            'name'=> $request->name,
            'from'=> $request->from,
            'to'=> $request->to,
            'published'=>($published=='published')?'published':'last_draft',
            'images' => json_encode($allImagePaths),
        ]);
    }


    public function scopeFilter(Builder $builder, $filter)
    {
        $options=array_merge([
            'name'=>null,
            'user_id'=>null,
            'from'=>null,
            'to'=>null,
        ],$filter);


        $builder->when($options['name'],function($query,$name){
            return $query->where('name',$name);
        });

        $builder->when($options['user_id'],function($query,$user){
            return $query->where('user_id',$user);
        });

        $builder->when($options['from'],function($query,$from){
            return $query->where('from',$from);
        });

        $builder->when($options['to'],function($query,$to){
            return $query->where('to',$to);
        });

    }
}
