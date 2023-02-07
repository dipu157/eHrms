<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class BaseDesignation extends Model
{
    protected $table= 'base_designation';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'designation_code',
        'name',
        'short_name',
        'description',
        'precedence',
        'status',
        'user_id',
    ];
}
