<?php

namespace App\Models\Roster;

use Illuminate\Database\Eloquent\Model;

class DutyLocation extends Model
{
    protected $table= 'duty_locations';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'old_id',
        'location',
        'description',
        'status',
        'user_id',
    ];
}
