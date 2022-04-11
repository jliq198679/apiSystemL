<?php

namespace App\Services;

use App\Models\FrameWeb;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class FrameWebService
{
    private $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    public function list()
    {
        $frameWebs = FrameWeb::where('active',1)->get()->toArray();
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
     * @return bool|void
     */
    public function update(FrameWeb $frameWeb,$input)
    {
        try{
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

            $frameWeb = FrameWeb::query()->where('id',$frameWeb->id)->update($data);
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
}
