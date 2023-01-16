<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Alkoumi\LaravelHijriDate\Hijri;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'v_all_user_emp_info';

    protected $connection = 'oracle';

    protected $appends = ['age'];

    public function getAgeAttribute() 
    {
        return  (int)round(Carbon::parse(Hijri::Date('Y-m-d'))->diffInMonths($this->birthdate) / 12);;
    }
}