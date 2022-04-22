<?php


namespace App\Rules;

use App\Models\FrameWeb;
use Illuminate\Contracts\Validation\Rule;
class FrameWebIsOfferDaily implements Rule
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
        $type = 'offer_daily';
        $frameWeb = FrameWeb::query()
            ->where('id',$value)
            ->where('type',$type)
            ->first();
        return !empty($frameWeb);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {

        return 'El :attribute debe ser un id valido y para oferta del dia';
    }
}
