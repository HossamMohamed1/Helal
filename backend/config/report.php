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
        'employee_list' => [
            'columns' => ['job_desc', 'dept_desc'],
            'unit' => 'number',
            'groupBy' => 'list',
            'className' => 'EmployeeReport',
        ],
        'employee_gender' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'gender',
            'className' => 'EmployeeReport',
        ],
        'employee_department' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'department',
            'className' => 'EmployeeReport',
        ],
        'employee_location' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'location',
            'className' => 'EmployeeReport',
        ],
        'employee_nationality' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'nationality',
            'className' => 'EmployeeReport',
        ],
        'employee_major' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'employee_major',
            'className' => 'EmployeeReport',
        ],
        '
        employee_job' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'job',
            'className' => 'EmployeeReport',
        ],
        'employee_age' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'age',
            'className' => 'EmployeeReport',
        ],
        'employee_qualification' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'qualification',
            'className' => 'EmployeeReport',
        ],
        'department_status' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'status',
            'className' => 'DepartmentReport',
        ],
        'department_location' => [
            'columns' => ['count'],
            'unit' => 'number',
            'groupBy' => 'location',
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
