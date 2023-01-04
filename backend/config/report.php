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
            'columns' => ['male','female'],
            'unit' => 'number',
            'className' => 'EmployeeReport'
        ]
    ],
];
