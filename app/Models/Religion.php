<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $fillable = ['name'];

    public function senior_citizens()
    {
        return $this->hasMany(SeniorCitizen::class);
    }
}
