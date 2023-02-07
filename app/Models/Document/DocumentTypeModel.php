<?php

namespace App\Models\Document;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DocumentTypeModel extends Model
{
    protected $table= 'document_type';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'name',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        
    ];
}
