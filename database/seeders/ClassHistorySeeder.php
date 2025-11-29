<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassHistory;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Term;
use App\Models\Block;

class ClassHistorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $classes = Classroom::all();
        $terms = Term::all();
        $blocks = Block::all();

        foreach ($users as $user) {
            $class = $classes->random();
            $term = $terms->random();
            $block = $blocks->random();
            ClassHistory::create([
                'user_id' => $user->id,
                'class_id' => $class->id,
                'terms_id' => $term->id,
                'block_id' => $block->id,
            ]);
        }
    }
}
