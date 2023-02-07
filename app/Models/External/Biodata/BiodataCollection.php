<?php

namespace App\Models\External\Biodata;

use App\Models\Circular\Circular;
use App\Models\Common\ApplicantStatusList;
use Illuminate\Database\Eloquent\Model;

class BiodataCollection extends Model
{
    protected $table= 'biodata_collections';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'issue_number',
        'name',
        'fathers_name',
        'mothers_name',
        'mobile_no',
        'circular_id',
        'speciality',
        'submission_date',
        'reference_name',
        'app_status_id',
        'interview_status',
        'board_decision',
        'joining_date',
        'remarks',
        'previous_id',
        'status',
        'user_id',
    ];

    public function circular()
    {
        return $this->belongsTo(Circular::class,'circular_id','id');
    }

    public function applicantstatus()
    {
        return $this->belongsTo(ApplicantStatusList::class,'app_status_id','id');
    }
}
