<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeniorCitizen extends Model
{
    protected $table = 'senior_citizens';
    protected $fillable = [
        'osca_id',
        'last_name',
        'first_name',
        'middle_name',
        'extension',
        'birthday',
        'age',
        'gender',
        'civil_status',
        'religion',
        'birth_place',
        'city_id',
        'barangay_id',
        'purok_id',

        'gsis_id',
        'philhealth_id',
        'illness',
        'disability',
        'educational_attainment',
        'is_active',
        'registry_number',
        

    ];
    // protected $guarded = [];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }
    public function purok(): BelongsTo
    {
        return $this->belongsTo(Purok::class);
    }
    // public function payroll()
    // {
    //     return $this->belongsTo(Payroll::class);
    // }
   
    public function payrolls()
    {
        return $this->belongsToMany(Payroll::class, 'payroll_senior_citizen')->withTimestamps();
    }
    

}
