<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    public $message = '';
    public $data = [];
    public $code;
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse()
    {
    	$response = [
            'success' => true,
            'data'    => $this->data,
            'message' => $this->message,
        ];
        return response()->json($response, $this->code ?? 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError()
    {
    	$response = [
            'success' => false,
            'data'    => '',
            'message' => $this->message ?? '',
        ];
        return response()->json($response, $this->code ?? 400);
    }
}