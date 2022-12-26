<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartLineOutput extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getOutputAttribute($value)
    {

        try {
            //code...
            return json_decode($value, true);
        } catch (\Throwable $th) {
            return [];
        }
    }

}
