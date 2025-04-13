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
        'description',
        'created_by'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contractPayments() {
        return $this->hasMany(ContractPayment::class, 'contract_id');
    }

    public function attachments() {
        return $this->hasMany(ContractAttachment::class, 'contract_id');
    }
}
