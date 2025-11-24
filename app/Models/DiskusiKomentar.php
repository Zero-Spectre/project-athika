<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskusiKomentar extends Model
{
    use HasFactory;

    protected $table = 'diskusi_komentar';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'diskusi_topik_id',
        'konten',
        'jumlah_like'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function diskusiTopik()
    {
        return $this->belongsTo(DiskusiTopik::class, 'diskusi_topik_id');
    }

    public function likes()
    {
        return $this->hasMany(DiskusiLike::class, 'diskusi_komentar_id');
    }
}