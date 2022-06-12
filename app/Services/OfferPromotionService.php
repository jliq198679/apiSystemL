<?php


namespace App\Services;


use App\Models\FrameWeb;
use App\Models\Offer;


class OfferPromotionService
{
    public function list($input)
    {
        return Offer::query()->where('is_promotion', '=', true)->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1

        );
    }

    public function store($offer_id)
    {
        return Offer::query()->where('id',$offer_id)->update(['is_promotion' => true]);
    }

    public function show($id)
    {
        return Offer::find($id);
    }

    public function destroy($id)
    {
        return Offer::query()->where('id',$id)->update(['is_promotion' => false]);
    }
}
