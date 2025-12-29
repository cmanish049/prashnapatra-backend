<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramUniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('programs_universities')->truncate();
        $programs = Program::all();
        $universities = University::all();
        foreach ($programs as $program) {
            $program->universities()->attach($universities);
        }
    }
}
