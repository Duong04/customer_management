<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    protected $table = 'employee_profiles';
    protected $fillable = [
        'code',
        'dob',
        'gender',
        'phone',
        'address',
        'join_date',
        'note',
        'user_id',
    ];
}
