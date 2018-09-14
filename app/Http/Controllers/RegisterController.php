<?php
/*
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register/index');
    }

    public function register()
    {
        $this->validate(request(),[
            'name' => 'required|min:3|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:5|confirmed',
        ]);

        $password = bcrypt(request('password'));
        $name = request('name');
        $email = request('email');
        $user = \App\User::create(compact('name', 'email', 'password'));
        return redirect('/login');
    }
}*/

/**
 * dingo demo
 */
namespace App\Http\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    use RegistersUsers;
    use Helpers;

    public function register(Request $request)
    {
        $valid = $this->valid($request->all());    //验证表单
        if ($valid->fails()) {
            $this->sendFailResponse($valid->errors());
        } else {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);
            if ($user) {
                $token = JWTAuth::fromuser($user);  //获取token

                return $this->response->array([
                    "token"       => $token,
                    "message"     => "Registration Success",
                    "status_code" => 201,
                ]);
            } else {
                $this->sendFailResponse("Register Error");
            }
        }
    }

    public function valid($data)
    {
        return Validator::make($data, [
            'name'     => 'required|unique:users|max:10',
            'email'    => 'required|unique:users|email',
            'password' => 'required|min:6',
        ]);
    }

    public function sendFailResponse($message)
    {
        return $this->response->error($message, 400);
    }
}