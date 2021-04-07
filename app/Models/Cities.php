<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Countries::class, "country_id", "id");
    }

    public function shops()
    {
        return $this->hasMany(Shops::class, "city_id", "id");
    }
}
