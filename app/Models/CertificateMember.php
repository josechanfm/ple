<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateMember extends Model
{
    use HasFactory;
    protected $table='certificate_member';
    protected $fillable=['certificate_id','member_id','number','number_display','display_name','issue_date','valid_from','valid_until','authorized_by','rank','avatar','remark'];
}
