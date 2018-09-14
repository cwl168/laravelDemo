<?php
//
//namespace App\Http\Controllers;
//
//use App\Jobs\SendReminderEmail;
//use Illuminate\Http\Request;
//use App\User;
//use JWTAuth;
//use Tymon\JWTAuth\Exceptions;
//
//class UserController extends Controller
//{
//    /*
//     * 个人介绍页面
//     */
//    public function show(User $user)
//    {
//
//        // 这个人的文章
//        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();
//        // 这个人的关注／粉丝／文章
//        $user = \App\User::withCount(['stars', 'fans', 'posts'])->find($user->id);
//        $fans = $user->fans()->get();
//        $stars = $user->stars()->get();
//
//        return view("user/show", compact('user', 'posts', 'fans', 'stars'));
//    }
//
//    public function fan(User $user)
//    {
//        $me = \Auth::user();
//        \App\Fan::firstOrCreate(['fan_id' => $me->id, 'star_id' => $user->id]);
//        return [
//            'error' => 0,
//            'msg' => ''
//        ];
//    }
//
//    public function unfan(User $user)
//    {
//        $me = \Auth::user();
//        \App\Fan::where('fan_id', $me->id)->where('star_id', $user->id)->delete();
//        return [
//            'error' => 0,
//            'msg' => ''
//        ];
//    }
//
//    public function setting()
//    {
//        $me = \Auth::user();
//        return view('user/setting', compact('me'));
//    }
//
//    public function settingStore(Request $request, User $user)
//    {
//        $this->validate(request(),[
//            'name' => 'min:3',
//        ]);
//
//        $name = request('name');
//        if ($name != $user->name) {
//            if(\App\User::where('name', $name)->count() > 0) {
//                return back()->withErrors(array('message' => '用户名称已经被注册'));
//            }
//            $user->name = request('name');
//        }
//        if ($request->file('avatar')) {
//            $path = $request->file('avatar')->storePublicly(md5(\Auth::id() . time()));
//            $user->avatar = "/storage/". $path;
//        }
//
//        $user->save();
//        return back();
//    }
//
//    public function sendReminderEmail(){
//        $user = User::findOrFail('67');
//        return $this->dispatch(new SendReminderEmail($user));
//    }
//
//    public function getAuthenticatedUser()
//    {
//        try {
//            if (! $user = JWTAuth::parseToken()->authenticate()) {
//                return response()->json(['user_not_found'], 404);
//            }
//        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
//            return response()->json(['token_expired'], $e->getStatusCode());
//        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
//            return response()->json(['token_invalid'], $e->getStatusCode());
//        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
//            return response()->json(['token_absent'], $e->getStatusCode());
//        }
//
//        return response()->json(compact('user'));
//    }
//}
//
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Transformers\UserTransformer;
use App\Jobs\SendReminderEmail;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\ResponseTrait;
use JWTAuth;
use Tymon\JWTAuth\Exceptions;
use App\Http\Controllers\Controller;
use Validator;

class UserController extends Controller
{
    use Helpers;

    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $valid = $this->valid($request->all());
        if ($valid->fails()) {
            return $this->response->error($valid->errors(), 400);
        } else {
            $ret = User::create([
                'name'     => $request->get('name'),
                'email'    => $request->get('email'),
                'password' => bcrypt($request->get('password')),
            ]);
            if ($ret) {
                return $this->sendSuccessResponse("Create Success", 201);
            } else {
                return $this->sendFailResponse("Create Fail", 500);
            }
        }
    }
    public function show($id)
    {
/*        $user = User::findOrFail($id);

        return $this->response->array($user->toArray());*/
        $user = User::findOrFail($id);

        return $this->response->item($user, new UserTransformer());
    }
    protected function valid($data)
    {
        return Validator::make($data, [
            'name'     => 'required|string|max:50',
            'email'    => 'required|string|email|max:255',
            'password' => 'required',
        ]);
    }

    protected function sendSuccessResponse($message, $status_code)
    {
        return $this->response->array([
            'message'     => $message,
            'status_code' => $status_code,
        ]);
    }

    protected function sendFailResponse($message, $status_code)
    {
        return $this->response->error($message, $status_code);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
