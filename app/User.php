<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userdetail()
    {
        return $this->hasOne('App\UserDetail','user_id' , 'id');
    }

    public function getImageUrlAttribute()
    {
        $imageUrl = "";
        if (isset($this->attributes['photo']) && $this->attributes['images'] != "") {
            $imageUrl = config('darkroom.URL.ARTICLE_IMAGE').$this->attributes['images'];
        }
        return $imageUrl;
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill','user_skills','user_id','skill_id');
    }
}
