<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class UseCase extends Model
{
    protected $table= 'use_cases';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'menu_type',
        'menu_id',
        'usecase_id',
        'name',
        'status',
    ];

    public function privillege()
    {
        return $this->hasMany(Privilege::class);
    }
}
