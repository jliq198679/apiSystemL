<?php


namespace App\Http\Controllers;



use App\Rules\ArrayIdsOffersExistRule;
use App\Rules\FrameWebIsOfferPromotion;
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
        $this->validate($request,[
            'frame_web_id' => 'required|exists:frames_web,id'
        ]);
        $response = $this->offerPromotionService->list($request->input('frame_web_id'));
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
            'frame_web_id' => ['required', new FrameWebIsOfferPromotion],
            'offer_ids' => ['required','array', new ArrayIdsOffersExistRule],
        ]);
        $response = $this->offerPromotionService->store($request->all());

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
