<?php


namespace App\Http\Controllers;


use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    private $usersService;
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list(Request $request)
    {
        $this->validate($request,[
            'rol' => ['nullable', Rule::in(['cliente', 'admin'])]
        ]);
        $response = $this->usersService->list($request->input('rol') ?? 'cliente');
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
            'email' => 'required|email|unique:users,email',
            'roles' => ['required','array',Rule::in(['cliente', 'admin'])],
            'name' => 'required',
            'password' => ['string',Rule::requiredIf(function () use ($request) {
                $input = $request->toArray();
                return in_array('admin',$input['roles']);
            })],
        ]);
        $response = $this->usersService->store($request->all());
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
            'email' => 'nullable|email|unique:users,email',
            'roles' => ['nullable','array',Rule::in(['cliente', 'admin'])],
            'name' => 'nullable',
            'password' => ['string',Rule::requiredIf(function () use ($request) {
                $input = $request->toArray();
                return in_array('admin',$input['roles']);
            })],
        ]);
        $user = $this->usersService->show($id);
        if(empty($user))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);

        $response = $this->usersService->update($user,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $user = $this->usersService->show($id);
        if(empty($user))
            return $this->errorResponse('No found',Response::HTTP_NOT_FOUND);
        $response = $this->usersService->destroy($user);
        return $this->successResponse($response);
    }

}
