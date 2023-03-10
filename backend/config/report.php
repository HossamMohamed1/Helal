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
        'employee_public_department' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'dept_desc',
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
        'employee_experience' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'experience',
            'className' => 'EmployeeReport',
        ],
        'employee_major' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'stage_no',
            'className' => 'EmployeeReport',
        ],
        'employee_major_for_years' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'major',
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
            'groupBy' => 'age',
            'className' => 'EmployeeReport',
        ],
        'employee_retirement' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'age',
            'className' => 'EmployeeReport',
        ],
        'age_distribution_for_employees' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'age',
            'className' => 'EmployeeReport',
        ],
        'employee_card' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'age',
            'className' => 'EmployeeReport',
        ],
        'employee_qualification' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'qualification_desc',
            'className' => 'EmployeeReport',
        ],
        'employee_absence' => [
            'columns' => ['attendance', 'late', 'no_late', 'early'],
            'unit' => 'number',
            'groupBy' => 'late_date',
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
            'columns' => ['birthdate'],
            'unit' => 'number',
            'groupBy' => 'dept_desc',
            'className' => 'DepartmentReport',
        ],
        'department_less_five_employee' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'dept_count',
            'className' => 'DepartmentReport',
        ],
    ],
];