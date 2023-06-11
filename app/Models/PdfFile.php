<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfFile extends Model
{
    use HasFactory;

    protected $table = 'pdf_files';

    protected $fillable = [
        'li01','li02','li03','li04',
    ];
}
