<?php

namespace App\Services;

use App\Models\FrameWeb;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class FrameWebService
{
    private $fileService;
    private $offerDailyService;
    private $offerPromotionService;
    public function __construct(FileService $fileService, OfferDailyService $offerDailyService, OfferPromotionService $offerPromotionService)
    {
        $this->fileService = $fileService;
        $this->offerDailyService = $offerDailyService;
        $this->offerPromotionService = $offerPromotionService;
    }
    public function list()
    {
        $frameWebs = FrameWeb::where('active',1)->get()->transform(function ($item){
            if($item->type == 'offer_daily')
                $item->offer_daily = $this->offerDailyService->list()->toArray();
            if($item->type == 'offer_promotion')
                $item->offer_promotion = $this->offerPromotionService->list($item->id)->toArray();
            return $item;
        });

        return $frameWebs;
    }

    /**
     * @param $input
     * @return void
     */
    public function store($input)
    {
        try{
            $data = [];
            $frame_name = Arr::pull($input,'frame_name');
            $type = Arr::pull($input,'type');
            Arr::set($data,'frame_name',$frame_name);
            $payload = [];
            foreach ($input as $key => $value)
            {
                if($value instanceof UploadedFile)
                {
                    $url = $this->fileService->upload($value);
                    Arr::set($payload,$key,$url);
                }
                else
                    Arr::set($payload,$key,$value);
            }
            $data = Arr::set($data,'payload_frame',$payload);
            $data = Arr::set($data,'active',1);
            $data = Arr::set($data,'type',$type);
            $frameWeb = FrameWeb::create($data);
            return $frameWeb;
        }
        catch (\Exception $exception)
        {
            abort($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @param FrameWeb $frameWeb
     * @param $input
     * @return FrameWeb
     */
    public function update(FrameWeb $frameWeb,$input)
    {
        try{
            if(count($input) == 0)
                throw new \Exception('parametros vacios',400);
            $data = [];
            $frame_name = Arr::pull($input,'frame_name');
            Arr::set($data,'frame_name',$frame_name);
            $payload = $frameWeb->payload_frame;
            foreach ($input as $key => $value)
            {
                if($value instanceof UploadedFile)
                {
                    $url = $this->fileService->upload($value);
                    Arr::set($payload,$key,$url);
                }
                else
                    Arr::set($payload,$key,$value);
            }
            Arr::set($data,'payload_frame',$payload);
            if(isset($input['active']) && !empty($input['active']))
                Arr::set($data,'active',1);
            if(isset($input['type']) && !empty($input['type']))
                Arr::set($data,'type',$input['type']);

            FrameWeb::query()->where('id',$frameWeb->id)->update($data);
            $frameWeb->refresh();
            return $frameWeb;
        }
        catch (\Exception $exception)
        {
            abort($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return FrameWeb::find($id);
    }

    /**
     * @param FrameWeb $frameWeb
     * @return bool|null
     */
    public function destroy(FrameWeb $frameWeb)
    {
        return $frameWeb->delete();
    }
}
