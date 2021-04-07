<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;

    protected $fillable = [
        "value",
        "type",
        "user_id",
        ];

    public function Item()
    {
        return ($this->type == "item") ? $this->hasOne(Items::class, "id", "value") : null;
    }

    public function getFileAttribute()
    {
        return \Illuminate\Support\Facades\URL::asset("storage/app/".$this->value);
    }
}
