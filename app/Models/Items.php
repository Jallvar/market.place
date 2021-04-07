<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $fillable = [
        "item_name",
        "description",
        "category_id",
        "cover",
        "price",
        "quantity",
        "shop_id"
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, "category_id", "id");
    }

    public function shop()
    {
        return $this->belongsTo(Shops::class, "shop_id", "id");
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachments::class);
    }

    public function cover()
    {
        return $this->hasOne(Attachments::class, "id", "cover_id");
    }

}
