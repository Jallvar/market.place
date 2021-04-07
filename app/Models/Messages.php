<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        "message",
        "user_to_id",
        "user_from_id",
    ];
    use HasFactory;

    public function attachments()
    {
        return $this->belongsToMany(Attachments::class);
    }

    public function user_to()
    {
        return $this->hasOne(Users::class, "id", "user_to_id");
    }

    public function user_from()
    {
        return $this->hasOne(Users::class, "id", "user_from_id");
    }

}
