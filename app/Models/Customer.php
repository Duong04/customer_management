<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'company',
        'short_name',
        'code',
        'address',
        'industry',
        'note',
        'status',
        'file',
        'province',
        'district',
        'ward',
    ];

    public function customerContact() {
        return $this->hasOne(CustomerContact::class, 'customer_id');
    }
}
