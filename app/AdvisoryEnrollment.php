<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisoryEnrollment extends Model
{
    // Table Name
    protected $table = 'asesoria_enrollment';
    // Primary Key
    public $primaryKey = 'asesoria_enrollment_id';

    public $timestamps = false;
}
