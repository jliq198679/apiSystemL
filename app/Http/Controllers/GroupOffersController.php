<?php


namespace App\Http\Controllers;


use App\Services\GroupOffersService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupOffersController extends Controller
{
    private $groupOffersService;
    public function __construct(GroupOffersService $groupOffersService)
    {
        $this->groupOffersService = $groupOffersService;
    }

    /**
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list()
    {
        $response = $this->groupOffersService->list();
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
            'name_group' => 'required',
        ]);
        $response = $this->groupOffersService->store($request->all());
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
            'name_group' => 'required',
        ]);
        $groupOffer = $this->groupOffersService->show($id);
        if(empty($groupOffer))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);

        $response = $this->groupOffersService->update($groupOffer,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $groupOffer = $this->groupOffersService->show($id);
        if(empty($groupOffer))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);
        $response = $this->groupOffersService->destroy($groupOffer);
        return $this->successResponse($response);
    }

}