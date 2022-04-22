<?php


namespace App\Rules;

use App\Models\Offer;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ArrayIdsOffersExistRule implements Rule
{
    private $arrayDif;
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ids = $value;
        $offerIds = Offer::query()->whereIn('id',$ids)->get()->pluck('id')->toArray();
        $this->arrayDif = array_values(array_diff($ids,$offerIds));

        if(count($this->arrayDif) == 0 )
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $str = '';
        $length = count($this->arrayDif);
        $counter = 1;
        foreach ($this->arrayDif as $value)
        {
            if($counter == $length)
                $str .= $value;
            else
                $str .= $value.',';
            $counter ++;
        }
        return 'El :attribute no debe contener ids invalidos de ofertas. Ids invalidos: '.$str;
    }
}
