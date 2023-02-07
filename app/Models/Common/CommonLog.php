<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class CommonLog extends Model
{
    protected $table= 'common_logs';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'usecase_id',
        'entry_type',
        'table_name',
        'old_data',
        'new_data',
        'description',
        'user_ip',
        'user_id',
    ];
}
