<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EssayAssignmentAttachment extends Model
{
    protected $fillable = [
        'essay_id', 'assignment_name'
    ];
}
