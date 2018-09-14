<?php

/*namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if(\Auth::check()) {
            return redirect("/posts");
        }

        return view("login/index");
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:30',
            'is_remember' => '',
        ]);

        $user = request(['email', 'password']);
        $remember = boolval(request('is_remember'));
        if (true == \Auth::attempt($user, $remember)) {
           return redirect('/posts');
        }

        return \Redirect::back()->withErrors("用户名密码错误");
    }

    public function logout()
    {
        \Auth::logout();
        return redirect('/login');
    }
}*/

/**
 * dingo demo
 */
namespace App\Http\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    public function login(Request $request)
    {
        $user = User::where('name', $request->email)->orwhere('email', $request->email)->firstOrFail();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = JWTAuth::fromuser($user);    //获取token
            $this->clearLoginAttempts($request);  //清除登录次数

            return $this->response->array([
                'token'       => $token,
                'message'     => "Login Success",
                'status_code' => 200,
            ]);
        } else {
            throw new UnauthorizedHttpException("Login Failed");
        }
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());    //token加入黑名单(注销)
        $this->guard()->logout();
    }
}
