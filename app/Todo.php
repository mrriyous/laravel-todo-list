<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
	protected $table = "todo";

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];



}
