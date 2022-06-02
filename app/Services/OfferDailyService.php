<?php


namespace App\Services;


use App\Models\GroupOffer;
use App\Models\Offer;
use App\Models\OfferDaily;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class OfferDailyService
{
    /**
     * ofertas diarias agrupadas por sus categorias
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return GroupOffer::query()->category()
            ->has('offers.offerDaily')
            ->orHas('subsCategory.offers.offerDaily')
            ->with([
                'subsCategory' => function($query){
                    $query->has('offers.offerDaily')
                        ->withCount('offers')
                        ->with('offers.offerDaily')
                    ;
                },
                'offers'=> function($query) {
                    $query->has('offerDaily')
                        ->with('offerDaily')

                    ;
                }
            ])
            ->withCount([
                'offers'=> function($query) {
                    $query->has('offerDaily')
                        ->with('offerDaily')

                    ;
                }
            ])
            ->get();
    }

    public function listCategory()
    {
        /** @var Collection $data */
        $data = $this->list();

        $data = $data->transform(function ($item){
            $counter = $item->offers_count;
            if($item->subsCategory->isNotEmpty()) {
                foreach ($item->subsCategory as $subCategory)
                {
                    $counter += $subCategory->offers_count;
                }
            }
            return [
                'id' => $item->id,
                'name_group_es' => $item->name_group_es ,
                'name_group_en' => $item->name_group_en,
                'count_daily' => $counter
            ];
        });
        return $data;
    }

    public function store($input)
    {
        $offerDaily = OfferDaily::query()->where([
            'frame_web_id' => $input['frame_web_id'],
            'offer_id' => $input['offer_id']
        ])
            ->whereRaw('date(created_at) = curdate()')
            ->first();
        $id = -1;
        if(!empty($offerDaily))
            $id = $offerDaily->id;

        return OfferDaily::query()->updateOrCreate([
           'id' => $id
       ],$input);
    }

    /**
     * @param $input
     */
    public function storePackage($input)
    {
        $frame_web_id = $input['frame_web_id'];
        $offers = $input['offers'];
        foreach ($offers as $offer)
        {
            $item = [];
            if(isset($offer['offer_id']) && !empty($offer['offer_id']) && !empty(Offer::find($offer['offer_id'])))
            {
                Arr::set($item,'frame_web_id',$frame_web_id);
                Arr::set($item,'offer_id',$offer['offer_id']);
                if(isset($offer['count_offer']) && is_int($offer['count_offer']))
                    Arr::set($item,'count_offer',$offer['count_offer']);
                else
                    Arr::set($item,'count_offer',0);

                if(isset($offer['price_cup']) && is_numeric($offer['price_cup']))
                    Arr::set($item,'price_cup',$offer['price_cup']);
                else
                    Arr::set($item,'price_cup',0);

                if(isset($offer['price_usd']) && is_numeric($offer['price_usd']))
                    Arr::set($item,'price_usd',$offer['price_usd']);
                else
                    Arr::set($item,'price_usd',0);
                $this->store($item);
            }
        }
    }

    public function show($id)
    {
        return OfferDaily::find($id);
    }

    public function update(OfferDaily $offerDaily,$input)
    {
        OfferDaily::where('id',$offerDaily->id)->update($input);
        $offerDaily->refresh();
        return $offerDaily;
    }

    public function destroy(OfferDaily $offerDaily)
    {
        return $offerDaily->delete();
    }


}
