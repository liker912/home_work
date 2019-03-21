<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    //
    protected $table = "market";

    protected $fillable = ["id", "link", "api_key"];

}
