<?php

namespace Database\Seeders;

use App\Models\TrackerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $trackerTypes = [
            ['name' => 'Weekly Lesson Plan','frequency'=> 'weekly', 'description' => 'Weekly class attendance record'],
            ['name' => 'Student Progress Report','frequency'=> 'monthly', 'description'=> 'Monthly student progress tracking'],
            ['name' => 'Attendance Tracker', 'frequency' => 'weekly', 'description'=> 'Weekly class attendance record'],
            ['name' => 'Assessment Results', 'frequency' => 'monthly', 'description'=> 'Monthly Assessment outcomes'],
            ['name'=> 'Term Report', 'frequency' => 'termly', 'description'=> 'End of Term Comprehensive report'],
            ['name' => 'Proffessional Development', 'frequency' => 'termly', 'description' => 'Teacher professional development tracker'],
        ];

        foreach ($trackerTypes as $type) {

            TrackerType::create($type);

        }
    }
}
