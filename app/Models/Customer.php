<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'fullname',
        'code',
        'address',
        'industry',
        'note',
        'status'
    ];

    public function customerContact() {
        return $this->belongsTo(CustomerContact::class, 'customer_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'customer_id');
    } 
}
