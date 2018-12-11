<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
     // Table Name
     protected $table = 'tipo_documento';
     // Primary Key
     public $primaryKey = 'tipo_documento_id';
 
     public $timestamps = false;
}
