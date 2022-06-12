<?php


namespace App\Services;


use App\Models\FrameWeb;
use App\Models\GroupOffer;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

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
                });
        return $query->with('groupOffer')->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1

        );
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
