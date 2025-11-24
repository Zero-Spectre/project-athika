<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;

    protected $table = 'kuis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'modul_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'score_weight'
    ];

    protected $casts = [
        'score_weight' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }
}