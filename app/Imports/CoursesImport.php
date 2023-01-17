<?php
namespace App\Imports;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CoursesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Course([
            'department_id' => $row['department_id'],
            'name' => $row['name'],
            'description' => $row['description'], 
            'chairman' => $row['chairman'],
        ]);
    }
}