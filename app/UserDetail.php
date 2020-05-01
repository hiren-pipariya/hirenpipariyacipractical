<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserDetail extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'user_name',
        'mobile',
        'gender',
        'photo',
    ];

    protected $appends = ['image']; // append image of user to userdetail data

    //mutetor for get image with userdetail object
    public function getImageAttribute()
    {
        $image = "";
        if (isset($this->attributes['photo']) && $this->attributes['photo'] != "") {
            $image = Storage::url($this->attributes['photo']);
        }
        return $image;
    }
}
