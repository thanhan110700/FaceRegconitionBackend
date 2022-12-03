<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Response structure json success.
     *
     * @param array       $data       Data return
     * @param int         $statusCode Status code 2xx : 200, 201
     * @param null|string $masterKey  Master key of response
     *
     * @return Illuminate\Http\Response response data json
     */
    public function responseSuccess($data = [], $statusCode = 200, $masterKey = null)
    {
        if (!empty($masterKey)) {
            $data = is_null($data) ? [] : $data;
            $response[$masterKey] = $data;
            return response()->json($response, $statusCode);
        }
        return response()->json($data, $statusCode);
    }

    /**
     * Response structure json error
     *
     * @param string $message    Message error
     * @param string $statusCode Status code
     *
     * @return Illuminate\Http\Response response data json
     */
    public function responseError($message, $statusCode)
    {
        $jsonOut = [
            'errors' => [$message],
        ];
        return response()->json($jsonOut, $statusCode);
    }
}
