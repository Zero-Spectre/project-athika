<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kursus;
use App\Models\Kuis;
use App\Models\HasilKuis;
use App\Models\Komentar;
use App\Models\ProgresPeserta;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'modul';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kursus_id',
        'quiz_id',
        'judul',
        'tipe_materi',
        'urutan',
        'konten_teks',
        'penjelasan',
        'url_video',
        'video_thumbnail',
        'video_deskripsi',
        'durasi_video'
    ];

    protected $casts = [
        'durasi_video' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Kuis::class, 'quiz_id');
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'modul_id');
    }

    public function hasilKuis()
    {
        return $this->hasMany(HasilKuis::class, 'modul_id');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'modul_id');
    }

    public function progresPesertas()
    {
        return $this->hasMany(ProgresPeserta::class, 'modul_id');
    }
}