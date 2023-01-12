<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Report Option Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the options for report services such
    | as Employee, Department, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
     */

    'type' => [
        'employee_gender' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'genderid',
            'className' => 'EmployeeReport',
        ],
        'employee_department' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'dept_desc',
            'className' => 'EmployeeReport',
        ],
        'employee_location' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'location_no',
            'className' => 'EmployeeReport',
        ],
        'employee_nationality' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'nationalityid',
            'className' => 'EmployeeReport',
        ],
        'employee_major' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'major_desc',
            'className' => 'EmployeeReport',
        ],
        'employee_job' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'job_desc',
            'className' => 'EmployeeReport',
        ],
        'employee_age' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'birthdate',
            'className' => 'EmployeeReport',
        ],
        'employee_qualification' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'qualification_desc',
            'className' => 'EmployeeReport',
        ],
        'employee_absence' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'qualification_desc',
            'className' => 'EmployeeReport',
        ],
        'department_status' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'dept_status',
            'className' => 'DepartmentReport',
        ],
        'department_location' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'location_no',
            'className' => 'DepartmentReport',
        ],
        'department_age' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'age',
            'className' => 'DepartmentReport',
        ],

    ],
];
