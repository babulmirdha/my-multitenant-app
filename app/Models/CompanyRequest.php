<?php

namespace App\Models;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyRequest extends Model
{
    use HasFactory, SoftDeletes, AutoUuid;

    protected $fillable = [
        'domain',
        'company_name',
        'contact_address',
        'contact_email',
        'contact_phone',
        'status',
    ];
}
