<?php

namespace App\Models\Ot;

use Illuminate\Database\Eloquent\Model;

class OtModel extends Model
{
     protected $table= 'ot_details';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'ot_number',
        'patient_name',
        'doctor_name',
        'description',
        'user_id',
        'status',
    ];
}
