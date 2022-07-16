<?php


namespace App\Services;


use App\Models\FrameWeb;
use App\Models\GroupOffer;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OffersService
{
    private $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function list($input)
    {
        $group_offers_ids = [];
        if(isset($input['category_id']))
        {
            $group_offers_ids = GroupOffer::query()->subCategory()->where('category_id',$input['category_id'])
                ->get()->pluck('id')->toArray();
            $group_offers_ids [] = intval($input['category_id']);
        }

        $query = Offer::query()
                ->when(isset($input['subCategory_id']), function (Builder $query) use ($input){
                    $query->whereHas('groupOffer',function ($query) use($input) {
                        $query->where('group_offer_id',$input['subCategory_id']);
                    });
                })
                ->when(isset($input['category_id']), function ($query) use($group_offers_ids){
                    $query->whereIn('group_offer_id',$group_offers_ids);
                })
                ->when(isset($input['search']) && !empty($input['search']),function ( $query) use ($input){
                    $search = strtolower($input['search']);
                  //  $query->whereRaw("LOWER(name_offer_es) like '%?%' ",[$search])
                  //         ->orWhereRaw("LOWER(name_offer_en) like '%?%' ",[$search]) ;
                })
                ->with('groupOffer.category');

        return $query->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1

        );
    }

    public function listNotDaily($input)
    {
        $data = GroupOffer::query()->category()
            ->whereHas('offers', function ( $q){
                    $q->doesntHave('offerDaily');
            })
            ->orWhereHas('subsCategory.offers', function ($q){
                $q->doesntHave('offerDaily');
            })
            ->with([
                'subsCategory' => function(  $query){
                    $query->whereHas('offers',function ( $q){
                        $q->doesntHave('offerDaily');
                    })
                     ->with(['offers'=> function($q){
                            $q->doesntHave('offerDaily');
                        }
                     ])
                    ;
                },
                'offers'=> function($query) {
                    $query->doesntHave('offerDaily');
                }
            ])
            ->get();
        return $data->transform(function ($item){
            $offers = [];
            if($item->subsCategory->isNotEmpty())
            {
                foreach ($item->subsCategory as $subCategory)
                {
                    foreach ($subCategory->offers->toArray() as $offer)
                        $offers [] = $offer;
                }
            }
            foreach ($item->offers->toArray() as $offer)
                $offers [] = $offer;
            return [
                'id' => $item->id,
                'name_group_es' => $item->name_group_es,
                'name_group_en' => $item->name_group_en,
                'offers' => $offers
            ];
        });

    }

    public function store($input)
    {
        try{
            if(isset($input['image']) && !empty('image'))
            {
                $image = Arr::pull($input,'image');
                $url = $this->fileService->upload($image);
                Arr::set($input,'url_imagen',$url);
            }
            $offer = Offer::query()->create($input);
            return $offer;
        }
        catch (\Exception $exception)
        {
            abort($exception->getCode(),$exception->getMessage());
        }
    }

    public function show($id)
    {
        return Offer::find($id);
    }

    public function update(Offer $offer,$input)
    {
        try{
            $input = Arr::only($input,[
                'name_offer_es',
                'name_offer_en',
                'description_offer_en',
                'description_offer_es',
                'price_cup',
                'price_usd',
                'image',
                'group_offer_id',
            ]);
            if(count($input) == 0)
                throw new \Exception('parametros vacios',400);
            if(isset($input['image']) && !empty('image'))
            {
                /**  todo eliminar image */
                $image = Arr::pull($input,'image');
                $url = $this->fileService->upload($image);
                Arr::set($input,'url_imagen',$url);
            }
           Offer::query()->whereKey($offer->id)->update($input);
           $offer->refresh();
           return $offer;
        }
        catch (\Exception $exception)
        {
            abort($exception->getCode(),$exception->getMessage());
        }
    }

    public function destroy(Offer $offer)
    {
        return $offer->delete();
    }


}
