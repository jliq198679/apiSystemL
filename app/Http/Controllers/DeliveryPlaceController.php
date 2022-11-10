<?php


namespace App\Http\Controllers;


use App\Services\DeliveryPlaceService;
use Illuminate\Http\Request;

class DeliveryPlaceController extends Controller
{
    private $deliveryPlaceService;
    public function __construct(DeliveryPlaceService $deliveryPlaceService )
    {
        $this->deliveryPlaceService = $deliveryPlaceService;
    }

    public function list(Request $request)
    {
        $this->validate($request,[
            'page' => ['nullable','integer'],
            'per_page' => ['nullable','integer'],
            'municipality_id' => ['nullable','exists:municipality,id']
        ]);
        $response = $this->deliveryPlaceService->list($request->all());
        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:delivery_place,name',
            'municipality_id' => ['required','exists:municipality,id']
        ]);

        $deliveryPlace = $this->deliveryPlaceService->store($request->all());
        return $this->successResponse($deliveryPlace);
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:delivery_place,name',
            'municipality_id' => ['required','exists:municipality,id']
        ]);
        $deliveryPlace = $this->deliveryPlaceService->find($id);
        if(empty($deliveryPlace))
            return $this->errorResponse('Not found',404);
        $response = $this->deliveryPlaceService->update($id,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $deliveryPlace = $this->deliveryPlaceService->find($id);
        if(empty($deliveryPlace))
            return $this->errorResponse('Not found',404);
        $response = $this->deliveryPlaceService->destroy($id);
        return $this->successResponse($response);
    }
}
