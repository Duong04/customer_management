<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPayment extends Model
{
    protected $table = 'contract_payments';
    protected $fillable = [
        'name',
        'code',
        'signer',
        'customer_id',
        'customer_representative_id',
        'customer_representative_id',
        'sign_date',
        'start_date',
        'end_date',
        'status',
        'contract_value',
        'note',
        'attachments',
        'created_by'
    ];
}
