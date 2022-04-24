<?php


return [
    /* Courses Model */
    'courses_model' => [
        7 => App\Course::class,
        8 => App\Models\Course::class,
    ],
    /*
|--------------------------------------------------------------------------
| Get the course table columns
|--------------------------------------------------------------------------
|
| The package assumes you have a table called courses with a course name and a short name
| You should set the name and short name columns here
| Ensure you set the name and short name columns to the same name as the table columns before running migrations.
| Incase you change the columns name of the course table, you should change the name of the columns here as well. 
|
*/
    'course_table_columns' => [
        'name' => 'CourseName',
        'short_name' => 'ShortCourseName'
    ]
];
