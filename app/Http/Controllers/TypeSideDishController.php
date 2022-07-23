<?php


namespace App\Http\Controllers;


use App\Services\TypeSideDishService;
use Illuminate\Http\Request;

class TypeSideDishController extends Controller
{
    private $typeSideDishService;
    public function __construct(TypeSideDishService $typeSideDishService )
    {
        $this->typeSideDishService = $typeSideDishService;
    }

    public function list(Request $request)
    {
        $response = $this->typeSideDishService->list($request->all());
        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name_type_side_dish_es' => 'required|unique:type_side_dish,name_type_side_dish_es',
            'name_type_side_dish_en' => 'required|unique:type_side_dish,name_type_side_dish_en'
        ]);

        $typeSideDish = $this->typeSideDishService->store($request->all());
        return $this->successResponse($typeSideDish);
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
            'name_type_side_dish_es' => 'nullable|unique:type_side_dish,name_type_side_dish_es',
            'name_type_side_dish_en' => 'nullable|unique:type_side_dish,name_type_side_dish_en'
        ]);
        $typeSideDish = $this->typeSideDishService->find($id);
        if(empty($typeSideDish))
            return $this->errorResponse('Not found',404);
        $response = $this->typeSideDishService->update($id,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $typeSideDish = $this->typeSideDishService->find($id);
        if(empty($typeSideDish))
            return $this->errorResponse('Not found',404);
        $response = $this->typeSideDishService->destroy($id);
        return $this->successResponse($response);
    }
}
