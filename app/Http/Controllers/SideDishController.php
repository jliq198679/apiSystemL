<?php


namespace App\Http\Controllers;


use App\Services\SideDishService;
use Illuminate\Http\Request;

class SideDishController extends Controller
{
    private $sideDishService;
    public function __construct(SideDishService $sideDishService )
    {
        $this->sideDishService = $sideDishService;
    }

    public function list(Request $request)
    {
        $this->validate($request,[
            'page' => ['nullable','integer'],
            'per_page' => ['nullable','integer'],
            'type_side_dish_id' => ['nullable','exists:type_side_dish,id']
        ]);
        $response = $this->sideDishService->list($request->all());
        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name_side_dish_es' => 'required|unique:side_dish,name_side_dish_es',
            'name_side_dish_en' => 'required|unique:side_dish,name_side_dish_en',
            'type_side_dish_id' => ['required','exists:type_side_dish,id']
        ]);

        $typeSideDish = $this->sideDishService->store($request->all());
        return $this->successResponse($typeSideDish);
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
            /*'name_side_dish_es' => 'nullable|unique:side_dish,name_side_dish_es',
            'name_side_dish_en' => 'nullable|unique:side_dish,name_side_dish_en',*/
            'type_side_dish_id' => ['nullable','exists:type_side_dish,id']
        ]);
        $sideDish = $this->sideDishService->find($id);
        if(empty($sideDish))
            return $this->errorResponse('Not found',404);
        $response = $this->sideDishService->update($id,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $sideDish = $this->sideDishService->find($id);
        if(empty($sideDish))
            return $this->errorResponse('Not found',404);
        $response = $this->sideDishService->destroy($id);
        return $this->successResponse($response);
    }
}
