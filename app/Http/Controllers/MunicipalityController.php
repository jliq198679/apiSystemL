<?php


namespace App\Http\Controllers;


use App\Services\MunicipalityService;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    private $municipalityService;
    public function __construct(MunicipalityService $municipalityService )
    {
        $this->municipalityService = $municipalityService;
    }

    public function list(Request $request)
    {/*
        $this->validate($request,[
            'page' => ['nullable','integer'],
            'per_page' => ['nullable','integer']
        ]);*/
        $response = $this->municipalityService->list($request->all());
        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|unique:municipality,id',
            'name' => 'required|unique:municipality,name',
        ]);

        $municipality = $this->municipalityService->store($request->all());
        return $this->successResponse($municipality);
    }

    public function update($id, Request $request)
    {
        $municipality = $this->municipalityService->find($id);
        if(empty($municipality))
            return $this->errorResponse('Not found',404);
        $response = $this->municipalityService->update($id,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $municipality = $this->municipalityService->find($id);
        if(empty($municipality))
            return $this->errorResponse('Not found',404);
        $response = $this->municipalityService->destroy($id);
        return $this->successResponse($response);
    }
}
