<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Subject::truncate();
        Schema::enableForeignKeyConstraints();

        $subjects = [
            [
                'name' => 'Computer Fundamentals & Applications',
                'code' => 'CACS101',
                'semester' => 1,
            ],
            [
                'name' => 'Society and Technology',
                'code' => 'CACO102',
                'semester' => 1,
            ],
            [
                'name' => 'English I',
                'code' => 'CAEN103',
                'semester' => 1,
            ],
            [
                'name' => 'Mathematics I',
                'code' => 'CAMT104',
                'semester' => 1,
            ],
            [
                'name' => 'Digital Logic',
                'code' => 'CACS105',
                'semester' => 1,
            ],
            [
                'name' => 'C Programming',
                'code' => 'CACS151',
                'semester' => 2,
            ],
            [
                'name' => 'Financial Accounting',
                'code' => 'CAAC152',
                'semester' => 2,
            ],
            [
                'name' => 'English II',
                'code' => 'CAEN153',
                'semester' => 2,
            ],
            [
                'name' => 'Mathematics II',
                'code' => 'CAMT154',
                'semester' => 2,
            ],
            [
                'name' => 'Microprocessor and Computer Architecture',
                'code' => 'CACS155',
                'semester' => 2,
            ],
            [
                'name' => 'Data Structures and Algorithms',
                'code' => 'CACS201',
                'semester' => 3,
            ],
            [
                'name' => 'Probability and Statistics',
                'code' => 'CAST202',
                'semester' => 3,
            ],
            [
                'name' => 'System Analysis and Design',
                'code' => 'CACS203',
                'semester' => 3,
            ],
            [
                'name' => 'OOP in Java',
                'code' => 'CACS204',
                'semester' => 3,
            ],
            [
                'name' => 'Web Technology',
                'code' => 'CACS205',
                'semester' => 3,
            ],
            [
                'name' => 'Operating System',
                'code' => 'CACS251',
                'semester' => 4,
            ],
            [
                'name' => 'Numerical Methods',
                'code' => 'CACS252',
                'semester' => 4,
            ],
            [
                'name' => 'Software Engineering',
                'code' => 'CACS253',
                'semester' => 4,
            ],
            [
                'name' => 'Scripting Language',
                'code' => 'CACS254',
                'semester' => 4,
            ],
            [
                'name' => 'Database Management System',
                'code' => 'CACS255',
                'semester' => 4,
            ],
            [
                'name' => 'Project I',
                'code' => 'CAPJ256',
                'semester' => 4,
            ],
            [
                'name' => 'MIS and E-Business',
                'code' => 'CACS301',
                'semester' => 5,
            ],
            [
                'name' => 'DotNet Technology',
                'code' => 'CACS302',
                'semester' => 5,
            ],
            [
                'name' => 'Computer Networking',
                'code' => 'CACS303',
                'semester' => 5,
            ],
            [
                'name' => 'Introduction to Management',
                'code' => 'CAMG304',
                'semester' => 5,
            ],
            [
                'name' => 'Computer Graphics and Animation',
                'code' => 'CACS305',
                'semester' => 5,
            ],
            [
                'name' => 'Mobile Programming',
                'code' => 'CACS351',
                'semester' => 6,
            ],
            [
                'name' => 'Distributed System',
                'code' => 'CACS352',
                'semester' => 6,
            ],
            [
                'name' => 'Applied Economics',
                'code' => 'CAEC353',
                'semester' => 6,
            ],
            [
                'name' => 'Advanced Java Programming',
                'code' => 'CACS354',
                'semester' => 6,
            ],
            [
                'name' => 'Network Programming',
                'code' => 'CACS355',
                'semester' => 6,
            ],
            [
                'name' => 'Project II',
                'code' => 'CAPJ356',
                'semester' => 6,
            ],
            [
                'name' => 'Cyber Law and Professional Ethics',
                'code' => 'CACS401',
                'semester' => 7,
            ],
            [
                'name' => 'Cloud Computing',
                'code' => 'CACS402',
                'semester' => 7,
            ],
            [
                'name' => 'Internship',
                'code' => 'CAIN403',
                'semester' => 7,
            ],
            [
                'name' => 'Image Processing',
                'code' => 'CAEL404',
                'semester' => 7,
            ],
            [
                'name' => 'Database Administration',
                'code' => 'CAEL405',
                'semester' => 7,
            ],
            [
                'name' => 'Network Administration',
                'code' => 'CACS406',
                'semester' => 7,
            ],
            [
                'name' => 'Operations Research',
                'code' => 'CAOR451',
                'semester' => 8,
            ],
            [
                'name' => 'Project III',
                'code' => 'CAPJ452',
                'semester' => 8,
            ],
            [
                'name' => 'Database Programming',
                'code' => 'CACS453',
                'semester' => 8,
            ],
            [
                'name' => 'Geographical Information System',
                'code' => 'CACS454',
                'semester' => 8,
            ],
            [
                'name' => 'Data Analysis and Visualization',
                'code' => 'CACS455',
                'semester' => 8,
            ],
            [
                'name' => 'Machine Learning',
                'code' => 'CACS456',
                'semester' => 8,
            ],
        ];
        $university = University::where('name', 'Tribhuwan University')->first();
        $program = Program::where('abbreviation', 'BCA')->first();

        $subjects = array_map(function ($subject) use ($university, $program) {
            $subject['university_id'] = $university->id;
            $subject['program_id'] = $program->id;
            $subject['created_at'] = now();

            return $subject;
        }, $subjects);

        Subject::insert($subjects);
    }
}
