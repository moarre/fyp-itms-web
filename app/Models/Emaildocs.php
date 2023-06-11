<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emaildocs extends Model
{
    public $table = 'emaildocs';

    protected $fillable = [
        'file_path1','file_path2',
    ];
}

