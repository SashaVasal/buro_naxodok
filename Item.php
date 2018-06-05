<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  	protected $fillable = ["description","title","status", "contact"];
	
}
