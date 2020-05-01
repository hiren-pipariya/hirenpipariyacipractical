<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRelations extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'send_by',
        'send_to',
        'status',
    ];

}
