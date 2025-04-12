<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
    protected $fillable = [
        'name',
        'code',
        'signer',
        'customer_id',
        'sign_date',
        'start_date',
        'end_date',
        'status',
        'contract_value',
        'note',
        'created_by'
    ];
}
