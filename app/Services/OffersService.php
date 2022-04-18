<?php


namespace App\Services;


use App\Models\FrameWeb;
use App\Models\Offer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class OffersService
{
    private $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function list()
    {
        return Offer::with('groupOffer')->get();
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
