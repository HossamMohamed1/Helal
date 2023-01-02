<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'data', 'config', 'input', 'output', 'file_count', 'excel_json', 'img'];
    public $inPermission = true;

    protected $casts = [
        'data' => 'array',
        'config' => 'array',
        'input' => 'array',
        'output' => 'array',
    ];

    public function files()
    {
        return $this->hasMany(ChartFile::class);
    }

}