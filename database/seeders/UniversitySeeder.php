<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('universities')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('universities')->insert([
            [
                'name' => 'Tribhuwan University',
                'label' => 'tribhuwan-university',
                'created_at' => now(),
            ],
            [
                'name' => 'Kathmandu University',
                'label' => 'kathmandu-university',
                'created_at' => now(),
            ],
            [
                'name' => 'Pokhara University',
                'label' => 'pokhara-university',
                'created_at' => now(),
            ],
            [
                'name' => 'Purbanchal University',
                'label' => 'purbanchal-university',
                'created_at' => now(),
            ],
            [
                'name' => 'Mid-Western University',
                'label' => 'mid-western-university',
                'created_at' => now(),
            ],
            [
                'name' => 'Far-Western University',
                'label' => 'far-western-university',
                'created_at' => now(),
            ],
        ]);
    }
}
