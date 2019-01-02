<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessCheckListItem extends Model
{
    // Table Name
    protected $table = 'proceso_checklist_item';
    // Primary Key
    public $primaryKey = 'proceso_checklist_item_id';

    public $timestamps = false;
}
