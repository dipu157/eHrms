<?php

namespace App\Models\Leaves;

use Illuminate\Database\Eloquent\Model;

class LeaveMaster extends Model
{
    protected $table= 'leave_master';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'name',
        'short_code',
        'particulars',
        'leave_type',
        'leave_limit',
        'yearly_limit',
        'is_carry_forward',
        'show_roster',
        'status',
        'user_id',
    ];
}
