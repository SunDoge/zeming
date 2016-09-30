<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'name',
        'version',
        'change_log',
        'install_url',
    ];

    protected $dates = ['deleted_at'];
}