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
    public function list(Request $request)
    {
        $this->validate($request,[
            'page' => ['nullable','integer'],
            'per_page' => ['nullable','integer'],
        ]);
        $response = $this->groupOffersService->list($request->all());
        return $this->successResponse($response);
    }

    public function listSubCategory($category_id)
    {
        $response = $this->groupOffersService->listSubCategory($category_id);
        return $this->successResponse($response);
    }

    public function listGroupWithOffer(Request $request)
    {
        $this->validate($request,[
            'page' => ['nullable','integer'],
            'per_page' => ['nullable','integer'],
        ]);
        $response = $this->groupOffersService->listGroupWithOffer($request->all());
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
            'name_group_es' => 'required',
            'name_group_en' => 'required',
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
            'name_group_es' => 'nullable',
            'name_group_en' => 'nullable',
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
