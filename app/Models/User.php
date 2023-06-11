<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fullname',
        'student_number',
        'ic',
        'address',
        'nama_penjaga',
        'alamat_penjaga',
        'phone_penjaga',
        'program_id',
        'semester_id',
        'coordinator_id',
        'lecturer_id',
        'interndata_id',
        'li01_id',
        'li02_id',
        'li03_id',
        'li04_id',
    ];

    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function coordinator(){
        return $this->belongsTo(Coordinator::class);
    }

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }

    public function pdf(){
        return $this->belongsTo(PdfFile::class);
    }

    public function interndata(){
        return $this->belongsTo(Interndata::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
