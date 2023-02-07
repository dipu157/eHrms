<?php

namespace App\Models\Document;

use App\User;

use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    protected $table= 'document';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'document_type_id',
        'uhid',
        'employee_id',
        'department_id',
        'item/procedure_name',
        'doctor_name',
        'doctor_department_name',
        'document_date',
        'document_photo',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentTypeModel::class,'document_type_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
