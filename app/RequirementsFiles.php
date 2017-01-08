<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequirementsFiles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requirement_id', 'path', 'name',
    ];
}
