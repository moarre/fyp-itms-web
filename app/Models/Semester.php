<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    public $table = 'semesters';

    protected $fillable = [
        'session','numSemester','coordinator_id','yearSemester',
    ];

    public function coordinator(){
        return $this->belongsTo(Coordinator::class);
    }
}
