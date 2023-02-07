<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table= 'trainings';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'participants',
        'attended',
        'last_date',
        'status',
        'user_id',
    ];

    public function trainingSchedule()
    {
        return $this->hasMany(TrainingSchedule::class,'training_id','id');
    }
}
