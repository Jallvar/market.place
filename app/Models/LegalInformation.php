<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        "shop_id",
        "ogrn",
        "inn",
        "kpp",
        "date_register",
        "adress",
        "name",
        "firstname",
        "surname",
        "middle_name",
    ];

    public function shop()
    {
        return $this->belongsTo(Shops::class, "id", "shop_id");
    }
}
