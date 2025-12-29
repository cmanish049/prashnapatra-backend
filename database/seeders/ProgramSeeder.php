<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Program::truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('programs')->insert([
            [
                'name' => 'Bachelor of Computer Application',
                'abbreviation' => 'BCA',
                'created_at' => now(),
            ],
            [
                'name' => 'Bachelor of Business Administration',
                'abbreviation' => 'BBA',
                'created_at' => now(),
            ],
            [
                'name' => 'Bachelor of Business Studies',
                'abbreviation' => 'BBS',
                'created_at' => now(),
            ],
            [
                'name' => 'Bachelor of Science',
                'abbreviation' => 'BSC',
                'created_at' => now(),
            ],
            [
                'name' => 'Bachelor of Information Management',
                'abbreviation' => 'BIM',
                'created_at' => now(),
            ],
            [
                'name' => 'Bachelor of Hotel Management',
                'abbreviation' => 'BHM',
                'created_at' => now(),
            ],
        ]);
    }
}
