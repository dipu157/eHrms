<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    protected $table= 'training_schedules';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'training_id',
        'description',
        'trainer',
        'start_from',
        'end_on',
        'participants',
        'attended',
        'closing_notes',
        'status',
        'user_id',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }


    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }

}
