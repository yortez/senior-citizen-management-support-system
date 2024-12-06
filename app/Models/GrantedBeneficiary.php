<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrantedBeneficiary extends Model
{
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
    public function seniors()
    {
        return $this->belongsToMany(SeniorCitizen::class, 'payroll_senior_citizen')->withTimestamps();
    }
    
}
