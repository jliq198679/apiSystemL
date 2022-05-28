<?php


namespace App\Http\Controllers;



use App\Services\OffersService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    private $offersService;
    public function __construct(OffersService $offersService)
    {
        $this->offersService = $offersService;
    }

    /**
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list()
    {
        $response = $this->offersService->list();
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
            'name_offer_es'=> 'required',
            'name_offer_en'=> 'required',
            'description_offer_en'=> 'required',
            'description_offer_es'=> 'required',
            'image' => 'nullable|image',
            'group_offer_id' => 'nullable|exists:group_offers,id',
        ]);
        $response = $this->offersService->store($request->all());
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
            'name_offer_es'=> 'nullable',
            'name_offer_en'=> 'nullable',
            'description_offer_en'=> 'nullable',
            'description_offer_es'=> 'nullable',
            'image' => 'nullable|image',
            'group_offer_id' => 'nullable|exists:group_offers,id',
        ]);
        $offer = $this->offersService->show($id);
        if(empty($offer))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);

        $response = $this->offersService->update($offer,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $offer = $this->offersService->show($id);
        if(empty($offer))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);
        $response = $this->offersService->destroy($offer);
        return $this->successResponse($response);
    }
}
