<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        return \response("Hello response");
    }

    public function header(Request $request): Response
    {
        $body = [
            "firstName" => "Ade",
            "lastName" => "Nafil",
        ];

        return \response(json_encode($body), 200)
            ->header('Content-Type', 'application/json')
            ->withHeaders([
               'Author' => "Ade Nafil Firmansah",
               'App' => "Belajar Laravel",
            ]);
    }

    public function responseView(Request $request): Response
    {
        return \response()
            ->view('hello', [
                "name" => "Ade"
            ]);
    }

    public function responseJson(Request $request): JsonResponse
    {
        $body = [
            "firstName" => "Ade",
            "lastName" => "Nafil",
        ];

        return \response()
            ->json($body);
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return \response()
            ->file(storage_path('app/public/pictures/Screenshot 2024-04-02 135834.png'));
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return \response()
            ->download(storage_path('app/public/pictures/Screenshot 2024-04-02 135834.png'));
    }
}
