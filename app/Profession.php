<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    // Table Name
    protected $table = 'profesion';
    // Primary Key
    public $primaryKey = 'profesion_id';

    public $timestamps = false;
}
