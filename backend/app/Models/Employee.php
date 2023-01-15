<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'v_all_user_emp_info';

    protected $connection = 'oracle';

    protected $appends = ['age'];

    public function getAgeAttribute() 
    {
        return $this->birthdate->diffInYears(\Carbon\Carbon::now());
    }
}