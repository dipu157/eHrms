<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $table= 'titles';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'status',
        'user_id',
    ];
}
