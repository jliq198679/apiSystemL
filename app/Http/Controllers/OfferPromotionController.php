<?php


namespace App\Http\Controllers;


use App\Services\OfferPromotionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferPromotionController extends Controller
{
    private $offerPromotionService;
    public function __construct(OfferPromotionService $offerPromotionService)
    {
        $this->offerPromotionService = $offerPromotionService;
    }

    /**
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list(Request $request)
    {
        $response = $this->offerPromotionService->list($request->all());
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
            'offer_id' => ['required','exists:offers,id'],
        ]);
        $response = $this->offerPromotionService->store($request->get('offer_id'));
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $offerPromotion = $this->offerPromotionService->show($id);
        if(empty($offerPromotion))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);
        $response = $this->offerPromotionService->destroy($offerPromotion);
        return $this->successResponse($response);
    }
}
