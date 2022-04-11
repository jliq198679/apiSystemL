<?php

namespace App\Http\Controllers;

use App\Services\FrameWebService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FrameWebController extends Controller
{
    private $frameWebService;
    public function __construct(FrameWebService $frameWebService)
    {
        $this->frameWebService = $frameWebService;
    }

    /**
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list()
    {
        $response = $this->frameWebService->list();
        return $this->successResponse($response);
    }

    /**
     * @param Request $request
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'frame_name' => 'required',
            'offer_daily' => 'nullable'
        ]);
        $response = $this->frameWebService->store($request->all());
        return $this->successResponse($response);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        $this->validate($request,[
            'frame_name' => 'nullable',
            'payload'=> 'nullable'
        ]);
        $frameWeb = $this->frameWebService->show($id);
        if(empty($frameWeb))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);

        $response = $this->frameWebService->update($frameWeb,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $frameWeb = $this->frameWebService->show($id);
        if(empty($frameWeb))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);
        $response = $this->frameWebService->destroy($frameWeb);
        return $this->successResponse($response);
    }
}
