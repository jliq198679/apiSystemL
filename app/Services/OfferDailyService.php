<?php


namespace App\Services;


use App\Models\GroupOffer;
use App\Models\Offer;
use App\Models\OfferDaily;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OfferDailyService
{
    public function listIndex($input)
    {
        $group_offers_ids = [];
        if(isset($input['category_id']))
        {
            $group_offers_ids = GroupOffer::query()->subCategory()->where('category_id',$input['category_id'])
                ->get()->pluck('id')->toArray();
            $group_offers_ids [] = intval($input['category_id']);
        }
        $query = Offer::query()
              ->has('offerDaily')
            ->when(isset($input['subCategory_id']), function (Builder $query) use ($input){
                $query->whereHas('groupOffer',function ($query) use($input) {
                    $query->where('group_offer_id',$input['subCategory_id']);
                });
            })
            ->when(isset($input['category_id']), function ($query) use($group_offers_ids){
                $query->whereIn('group_offer_id',$group_offers_ids);
            })
              ->with('offerDaily')
        ;
        return $query->with('groupOffer')->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1

        );
    }
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
                        ->with('offerDaily');
                }
            ])
            ->withCount([
                'offers'=> function($query) {
                    $query->has('offerDaily')
                        ->with('offerDaily');
                }
            ])
            ->get();
    }

    public function previous($input)
    {
        $query = Offer::query()->has('offerDailyPrevious')->with('offerDailyPrevious');

        return $query->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1
        );
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

    public function listSubCategory($category)
    {
        return GroupOffer::query()->subCategory()
            ->where('category_id',$category)
            ->has('offers.offerDaily')
            ->get();
    }

    public function store($input)
    {
        $offer = Offer::find($input['offer_id']);
        if(empty($offer))
            return;
        Arr::set($input,'price_cup',$offer->price_cup);
        Arr::set($input,'price_usd',$offer->price_usd);

        $offerDaily = OfferDaily::query()->where([
            'offer_id' => $offer->id
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
        DB::beginTransaction();
        try {
            $offers = $input['offers'];
            foreach ($offers as $offer)
            {
                $item = [];
                if(isset($offer['offer_id']) && !empty($offer['offer_id']) )
                {
                    $_offer = Offer::find($offer['offer_id']);
                    if(empty($offer))
                        continue;
                    Arr::set($item,'offer_id',$_offer->id);
                    if(isset($offer['count_offer']) && is_int($offer['count_offer']))
                        Arr::set($item,'count_offer',$offer['count_offer']);
                    else
                        Arr::set($item,'count_offer',0);

                    Arr::set($item,'price_cup',$_offer->price_cup);
                    Arr::set($item,'price_usd',$_offer->price_usd);
                    $this->store($item);
                }
            }
            DB::commit();
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
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
