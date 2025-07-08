<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function wells()
    {
        return $this->hasMany(Well::class);
    }
    // public function Structure_description()
    // {
    //     return $this->hasMany(Structure_descriotion::class);
    // }
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function scopeFilter(Builder $builder,$filters)
    {
        $options=array_merge([
            'name'=>null,
            'email'=>null,
            'type'=>null
        ],$filters);

        $builder->when($options['name'],function($query,$name){
            return $query->where('name',$name);
        });

        $builder->when($options['email'],function($query,$email){
            return $query->where('email',$email);
        });

        $builder->when($options['type'],function($query,$type){
            return $query->where('type',$type);
        });
    }
}
