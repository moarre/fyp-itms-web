<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public $table = 'programs';

    protected $fillable = [
        'code','name','coordinator_id',
    ];

    public function coordinator(){
        return $this->belongsTo(Coordinator::class);
    }
}
