<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMean extends Model
{
    // Table Name
    protected $table = 'metodo_contacto';
    // Primary Key
    public $primaryKey = 'metodo_contacto_id';

    public $timestamps = false;
}
