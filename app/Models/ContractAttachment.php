<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractAttachment extends Model
{
    protected $table = 'contract_attachments';
    protected $fillable = [
        'file_path',
        'note',
        'contract_id'
    ];
}
