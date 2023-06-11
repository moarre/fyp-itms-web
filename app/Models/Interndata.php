<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interndata extends Model
{
    public $table = 'interndata';

    protected $fillable = [
        'companyName','companyAddress','companyEmail','dateDuty','periodDuty','personinCharge',
    ];
}
