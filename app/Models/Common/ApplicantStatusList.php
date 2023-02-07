<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class ApplicantStatusList extends Model
{
    protected $table= 'applicants_status_list';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'status_name',
        'status',
        'user_id',
    ];
}
