<?php


namespace App\Rules;


use App\Models\GroupOffer;
use Illuminate\Contracts\Validation\Rule;

class ValidationSubCategory implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $item = GroupOffer::query()->where('id',$value)->whereNotNull('category_id')->first();
        return !empty($item);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {

        return 'El :attribute debe ser una subcategoria';
    }
}
