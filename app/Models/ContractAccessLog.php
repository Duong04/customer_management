<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractAccessLog extends Model
{
    protected $table = 'contract_access_logs';
    protected $fillable = [
        'contract_id',
        'user_id',
        'accessed_at',
        'note'
    ];
}
