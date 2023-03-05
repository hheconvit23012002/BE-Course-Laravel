<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourseImport implements ToArray, WithHeadingRow
{
    public function array(array $array)
    {
        foreach ($array as $each) {
            try {
                $courseName = $each['name'];
                $description = $each['description'];
                $start_date = $each['start_date'];
                $end_date = $each['end_date'];
                Course::create([
                    'name' => $courseName,
                    'description' => $description,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
            } catch (\Exception $exception) {
                dd($each);
            }
        }
    }
}
