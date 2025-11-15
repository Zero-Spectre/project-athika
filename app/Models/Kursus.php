<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;

    protected $table = 'kursus';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'instruktur_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'thumbnail',
        'status_publish'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function instruktur()
    {
        return $this->belongsTo(User::class, 'instruktur_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function moduls()
    {
        return $this->hasMany(Modul::class, 'kursus_id');
    }

    // Relationship to get all progress records through modules
    public function progresPesertas()
    {
        return $this->hasManyThrough(ProgresPeserta::class, Modul::class, 'kursus_id', 'modul_id');
    }
}