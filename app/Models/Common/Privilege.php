<?php

namespace App\Models\Common;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table= 'privileges';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'user_id',
        'menu_id',
        'group_id',
        'view',
        'add',
        'edit',
        'delete',
        'privilege',
        'approver_id',
    ];

    public function usecase()
    {
        return $this->belongsTo(UseCase::class,'menu_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
