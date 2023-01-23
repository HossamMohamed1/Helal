<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'dept';

    protected $connection = 'oracle';

    public function parentDepartment()
    {
        return $this->belongsTo(Department::class, 'dept_parent', 'dept_no');
    }
}