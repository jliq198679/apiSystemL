<?php


namespace App\Http\Controllers;


use App\Rules\FrameWebIsOfferDaily;
use App\Services\OfferDailyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferDailyController extends Controller
{
    private $offerDailyService;
    public function __construct(OfferDailyService $offerDailyService)
    {
        $this->offerDailyService = $offerDailyService;
    }

    /**
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list()
    {
        $response = $this->offerDailyService->list();
        return $this->successResponse($response);
    }

    public function listCategory()
    {
        $response = $this->offerDailyService->listCategory();
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
            'frame_web_id' => 'required|exists:frames_web,id',
            'offer_id' => 'required|exists:offers,id',
            'price_usd'=> 'nullable',
            'price_cup'=> 'nullable',
            'count_offer'=> 'required',
        ]);
        $response = $this->offerDailyService->store($request->all());
        return $this->successResponse($response);
    }

    /**
     * @param Request $request
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storePackage(Request $request)
    {
        $this->validate($request,[
            'frame_web_id' => ['required', new FrameWebIsOfferDaily],
            'offers'=> ['required','array']
        ]);
        $this->offerDailyService->storePackage($request->all());
        return $this->successResponse([]);
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
            'frame_web_id' => ['required',new FrameWebIsOfferDaily],
            'offer_id' => 'required|exists:offers,id',
            'price_usd'=> 'nullable',
            'price_cup'=> 'nullable',
            'count_offer'=> 'required',
        ]);
        $offerDaily = $this->offerDailyService->show($id);
        if(empty($offerDaily))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);

        $response = $this->offerDailyService->update($offerDaily,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $offerDaily = $this->offerDailyService->show($id);
        if(empty($offerDaily))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);
        $response = $this->offerDailyService->destroy($offerDaily);
        return $this->successResponse($response);
    }
}
