<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\HasilKuis;
use App\Models\Komentar;
use App\Models\Kursus;
use App\Models\ProgresPeserta;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'peran',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Automatically hash password when setting it
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Relationships
    public function hasilKuis()
    {
        return $this->hasMany(HasilKuis::class, 'user_id');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'user_id');
    }

    public function kursusAsInstruktur()
    {
        return $this->hasMany(Kursus::class, 'instruktur_id');
    }

    public function progresPesertas()
    {
        return $this->hasMany(ProgresPeserta::class, 'user_id');
    }
}