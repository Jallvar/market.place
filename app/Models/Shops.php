<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Shops
 * @package App\Models
 * @mixin Builder
 */
class Shops extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "name_shop",
        "description",
        "phone",
        "email",
        "site",
        "work_time",
        "min_price",
        "city_id",
        "logo",
    ];

    protected $attributes = [
        "phone_active" => false,
        "active" => false,
    ];


    public function getIsOwnerAttribute($value)
    {
        if(!Auth::check())
            return false;

        return $this->user_id == Auth::user()->id;
    }
    public function items()
    {
        return $this->hasMany(Items::class, "shop_id", "id");
    }

    public function city()
    {
        return $this->belongsTo(Cities::class, "city_id", "id");
    }

    public function legal_information()
    {
        return $this->hasOne(LegalInformation::class, "shop_id", "id");
    }

    public function deliveries()
    {
        return $this->belongsToMany(Deliveries::class)->as("deliveries");
    }

}
