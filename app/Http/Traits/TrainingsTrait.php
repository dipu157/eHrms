<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/5/19
 * Time: 11:11 AM
 */

namespace App\Http\Traits;

use App\Models\Employee\EmpProfessional;
use Illuminate\Support\Facades\DB;

trait TrainingsTrait
{
    public function getTraineeCountParticipant($scheduleId, $departmentId) {


        $selected = EmpProfessional::query()->where('company_id',$this->company_id)
            ->where('department_id',5)
            ->whereHas('trainees',function($query) use($scheduleId){
                $query->where('training_schedule_id',$scheduleId);
            })
            ->count();

        return $selected;
    }

}