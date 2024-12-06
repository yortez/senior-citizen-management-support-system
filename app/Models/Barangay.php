<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Barangay extends Model
{
    public function senior_citizens(): HasMany
    {
        return $this->hasMany(SeniorCitizen::class);
    }
}
