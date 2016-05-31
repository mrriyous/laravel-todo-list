<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $dates = ['created_at','updated_at','done_at'];
}
