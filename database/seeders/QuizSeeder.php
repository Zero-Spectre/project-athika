<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kuis;
use App\Models\Modul;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first module
        $modul = Modul::first();
        
        if ($modul) {
            // Create a sample quiz for the module
            Kuis::create([
                'modul_id' => $modul->id,
                'question' => 'What is the capital of Indonesia?',
                'option_a' => 'Jakarta',
                'option_b' => 'Bandung',
                'option_c' => 'Surabaya',
                'option_d' => 'Medan',
                'correct_answer' => 'A',
                'score_weight' => 1
            ]);
            
            Kuis::create([
                'modul_id' => $modul->id,
                'question' => 'Which programming language is used for Laravel framework?',
                'option_a' => 'Python',
                'option_b' => 'JavaScript',
                'option_c' => 'PHP',
                'option_d' => 'Java',
                'correct_answer' => 'C',
                'score_weight' => 1
            ]);
        }
    }
}