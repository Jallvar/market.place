<?php

namespace App\Rules;

use App\Models\Shops;
use Illuminate\Contracts\Validation\Rule;

class ShopEditRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (Shops::where($attribute, $value)->where("user_id", "!=", auth()->user()->id)->exists())? false : true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute уже используется!';
    }
}
