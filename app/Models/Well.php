<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Well extends Model
{
    use HasFactory;
    protected $table='wells';
    protected $fillable=[
        'name','from','to','well','rig','images','user_id','published'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function surveys_well()
    {
        return $this->hasMany(SurveyWell::class);
    }
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function Structure_descriptions()
    {
        return $this->belongsToMany(Structure_description::class
            ,'well_data','well_id','structure_description_id')
            ->withPivot(['data'])
            ->using(Well_data::class);
    }

    public function well_data()
    {
        return $this->hasMany(Well_data::class);
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

        $well = Well::create([
            'name' => $request->post('name'),
            'from' => $request->post('from'),
            'to' => $request->post('to'),
            'user_id' => Auth::guard('sanctum')->id(),
            'images' => json_encode($imagePaths), // Store the array of image paths
            'published' => ($published == 'published') ? 'published' : 'as_draft',
        ]);

        return $well;
    }

    public static function updateWell($well, $request, $published)
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

        // Update the well with the combined image paths
        $well->update([
            'name' => $request->name,
            'from' => $request->from,
            'to' => $request->to,
            'published' => ($published == 'published') ? 'published' : 'last_draft',
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
