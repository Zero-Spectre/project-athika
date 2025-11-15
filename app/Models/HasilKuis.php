<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKuis extends Model
{
    use HasFactory;

    protected $table = 'hasil_kuis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'modul_id',
        'score'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }
}