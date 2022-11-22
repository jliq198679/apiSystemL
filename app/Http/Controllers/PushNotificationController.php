<?php


namespace App\Http\Controllers;


use App\Services\PushNotificationService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    private $pushNotificationService;
    public function __construct(PushNotificationService $pushNotificationService )
    {
        $this->pushNotificationService = $pushNotificationService;
    }

    public function list(Request $request)
    {
        $this->validate($request,[
            'page' => ['nullable','integer'],
            'per_page' => ['nullable','integer']
        ]);
        $response = $this->pushNotificationService->list($request->all());
        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|unique:notification,title',
            'body' => 'required'
        ]);

        $pushNotification = $this->pushNotificationService->store($request->all());
        return $this->successResponse($pushNotification);
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
            'title' => 'required|unique:notification,title',
            'body' => 'required'
        ]);
        $pushNotification = $this->pushNotificationService->find($id);
        if(empty($pushNotification))
            return $this->errorResponse('Not found',404);
        $response = $this->pushNotificationService->update($id,$request->all());
        return $this->successResponse($response);
    }

    public function destroy($id)
    {
        $pushNotification = $this->pushNotificationService->find($id);
        if(empty($pushNotification))
            return $this->errorResponse('Not found',404);
        $response = $this->pushNotificationService->destroy($id);
        return $this->successResponse($response);
    }

    public function send(Request $request)
    {
        $response = $this->pushNotificationService->send();

        return $this->successResponse($response);
    }
}
