<?php


namespace App\Http\Controllers;


use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingService;
    public function __construct(SettingService $settingService )
    {
        $this->settingService = $settingService;
    }

    public function get(Request $request)
    {
        $response = $this->settingService->get();
        return $this->successResponse($response);
    }

    public function update(Request $request)
    {
        $setting = $this->settingService->get();
        $response = empty($setting) ? $this->settingService->store($request->all())
                                    : $this->settingService->update($request->all());
        return $this->successResponse($response);
    }
}
