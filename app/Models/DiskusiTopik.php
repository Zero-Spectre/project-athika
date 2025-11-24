<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskusiTopik extends Model
{
    use HasFactory;

    protected $table = 'diskusi_topik';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'judul',
        'konten',
        'kategori_id',
        'modul_id',
        'jumlah_komentar',
        'jumlah_like',
        'is_resolved'
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }

    public function komentars()
    {
        return $this->hasMany(DiskusiKomentar::class, 'diskusi_topik_id');
    }

    public function likes()
    {
        return $this->hasMany(DiskusiLike::class, 'diskusi_topik_id');
    }
}