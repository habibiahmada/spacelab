<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\CompanyRelation;

class CompanyRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $majorIds = DB::table('majors')->pluck('id');
        $companyIds = DB::table('companies')->pluck('id');
        if ($majorIds->isEmpty() || $companyIds->isEmpty()) {
            $this->command->info('⚠️  Tabel majors atau companies kosong. Jalankan MajorSeeder dan CompanySeeder terlebih dahulu agar relasi bisa dibuat.');
            return;
        }
        $partnershipTypes = ['internship', 'recruitment', 'mou', 'scholarship'];

        foreach ($companyIds as $companyId) {
            // pick a single random major for this company relation
            $majorId = $majorIds->random();

            CompanyRelation::create([
                'company_id' => $companyId,
                'major_id' => $majorId,
                'partnership_type' => $partnershipTypes[array_rand($partnershipTypes)],
                'status' => 'active',
                'start_date' => Carbon::now()->subMonths(rand(1, 12))->toDateString(),
                'end_date' => Carbon::now()->addYears(rand(1, 3))->toDateString(),
                'document_link' => 'https://drive.google.com/file/d/dummy-contract.pdf',
            ]);
        }
    }
}
