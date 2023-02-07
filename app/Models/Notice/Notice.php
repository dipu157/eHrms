<?php

namespace App\Models\Notice;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table= 'notices';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'notice_date',
        'expiry_date',
        'title',
        'description',
        'sender',
        'type',
        'confidentiality',
        'receiver',
        'file_path',
        'status',
        'user_id',
    ];
}
