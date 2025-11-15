<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresPeserta extends Model
{
    use HasFactory;

    protected $table = 'progres_peserta';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'modul_id',
        'completed',
        'completed_at'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
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