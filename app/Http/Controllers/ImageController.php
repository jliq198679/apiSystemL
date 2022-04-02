<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function upload(Request $request)
    {
        $this->validate($request,[
            'file' => ['required','image']
        ]);
        $response = $this->fileService->upload($request->file);
        return $this->successResponse($response);
    }
}
