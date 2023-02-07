<?php

namespace App\Models\Common;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LastBatchProcess extends Model
{
    protected $table= 'last_batch_processes';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'usecase_id',
        'process_name',
        'process_date_param',
        'user_ip',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
