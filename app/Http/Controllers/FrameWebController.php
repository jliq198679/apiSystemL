<?php

namespace App\Http\Controllers;

use App\Services\FrameWebService;
use Illuminate\Http\Request;

class FrameWebController extends Controller
{
    private $frameWebService;
    public function __construct(FrameWebService $frameWebService)
    {
        $this->frameWebService = $frameWebService;
    }

    public function list()
    {
        $response = $this->frameWebService->list();
        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'frame_name' => 'required',
        ]);
        $response = $this->frameWebService->store($request->all());
        return $this->successResponse($response);
    }
}
