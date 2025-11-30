<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We'll seed companies independent of majors; relations can be created by CompanyRelationSeeder
        for ($i = 0; $i < 10; $i++) {
            $name = fake()->company();

            // Use same approach as MajorSeeder for logo generation: deterministic avatar URL using a seed
            $logo = 'https://api.dicebear.com/7.x/notionists/svg?seed=' . urlencode(Str::slug($name));

            Company::updateOrCreate(
                ['name' => $name],
                [
                    'logo' => $logo,
                    'website' => fake()->url(),
                ]
            );
        }
    }
}