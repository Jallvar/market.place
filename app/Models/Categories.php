<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->hasMany(Shops::class, "category_id", "id");
    }

    public function categories()
    {
        return $this->hasMany(Categories::class);
    }

    public function children()
    {
        return $this->hasMany(Categories::class)->with("categories");
    }

}
