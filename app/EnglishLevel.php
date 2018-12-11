<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnglishLevel extends Model
{
    // Table Name
    protected $table = 'nivel_ingles';
    // Primary Key
    public $primaryKey = 'nivel_ingles_id';

    public $timestamps = false;
}
