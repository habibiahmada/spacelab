<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Block;
use App\Models\Term;

class BlockSeeder extends Seeder
{
    public function run(): void
    {
        $term = Term::where('is_active', true)->first();

        if (! $term) {
            $this->command->warn('⚠️ TermSeeder must run before BlockSeeder.');
            return;
        }

        Block::updateOrCreate(
            ['terms_id' => $term->id, 'name' => 'Blok 1'],
            ['start_date' => $term->start_date, 'end_date' => $term->end_date]
        );

        $this->command->info('✅ BlockSeeder created initial block for active term.');
    }
}
