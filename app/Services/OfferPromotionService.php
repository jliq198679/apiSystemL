<?php


namespace App\Services;


use App\Models\FrameWeb;
use App\Models\OfferPromotion;

class OfferPromotionService
{
    public function list($frame_web_id)
    {
        return OfferPromotion::where('frame_web_id',$frame_web_id)->with('offer')->get();
    }

    public function store($input)
    {
        $frame_web_id = $input['frame_web_id'];
        $idsOffers = $input['offer_ids'];
        $frame_web = FrameWeb::find($frame_web_id);
        $frame_web->promotionOffers()->sync($idsOffers);
        return $this->list($frame_web_id);
    }

    public function show($id)
    {
        return OfferPromotion::find($id);
    }

    public function destroy($id)
    {
        return OfferPromotion::where('id',$id)->delete();
    }
}
