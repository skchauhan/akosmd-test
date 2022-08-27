<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginValidator;
use App\Http\Controllers\API\V1\BaseController as BaseController;

class RegisterController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginValidator $request)
    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            $this->data = $success ?? [];
            return $this->sendResponse();
        } else{
            $this->message = __('lang.invalid_cred');
            $this->code = 401;
            return $this->sendError();
        } 
    }

}