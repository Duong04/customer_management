<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPayment extends Model
{
    protected $table = 'contract_payments';
    protected $fillable = [
        'contract_id',
        'payment_method',
        'bank_name',
        'account_number',
        'account_holder',
        'amount',
        'payment_date',
        'status',
    ];
}
