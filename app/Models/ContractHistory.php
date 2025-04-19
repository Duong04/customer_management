<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractHistory extends Model
{
    protected $table = 'contract_histories';
    protected $fillable = [
        'contract_id',
        'changed_by',
        'action',
        'note'
    ];

    public function changedBy() {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
