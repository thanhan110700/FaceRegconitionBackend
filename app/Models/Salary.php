<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class Salary extends Model
{
    use HasFactory, Compoships;

    protected $table = 'salaries';
}
