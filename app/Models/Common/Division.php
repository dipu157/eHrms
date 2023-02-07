<?php

namespace App\Models\Common;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table= 'divisions';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'division_code',
        'name',
        'short_name',
        'description',
        'started_from',
        'report_to',
        'approval_authority',
        'headed_by',
        'second_man',
        'email',
        'middle_name',
        'emp_count',
        'approved_manpower',
        'top_rank',
        'status',
        'user_id',
    ];

}
