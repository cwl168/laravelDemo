<?php

namespace App\Http\Controllers;

use App\Jobs\SendReminderEmail;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator as QrCode;
use Tymon\JWTAuth\Exceptions;
use App\Http\Sms\SmsSenderContract;
use App\Http\Sms\TwilioSender;
use App\Http\Sms\NexmoSender;
use PaymentGateway\PayFacade;

class UserController extends Controller
{
    /*
     * 个人介绍页面
     */
    public function show(User $user)
    {
        // 这个人的文章
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();
        // 这个人的关注／粉丝／文章
        $user  = \App\User::withCount(['stars', 'fans', 'posts'])->find($user->id);
        $fans  = $user->fans()->get();
        $stars = $user->stars()->get();

        return view("user/show", compact('user', 'posts', 'fans', 'stars'));
    }

    public function fan(User $user)
    {
        $me = \Auth::user();
        \App\Fan::firstOrCreate(['fan_id' => $me->id, 'star_id' => $user->id]);

        return [
            'error' => 0,
            'msg'   => '',
        ];
    }

    public function unfan(User $user)
    {
        $me = \Auth::user();
        \App\Fan::where('fan_id', $me->id)->where('star_id', $user->id)->delete();

        return [
            'error' => 0,
            'msg'   => '',
        ];
    }

    public function setting()
    {
        $me = \Auth::user();

        return view('user/setting', compact('me'));
    }

    public function settingStore(Request $request, User $user)
    {
        $this->validate(request(), [
            'name' => 'min:3',
        ]);

        $name = request('name');
        if ($name != $user->name) {
            if (\App\User::where('name', $name)->count() > 0) {
                return back()->withErrors(['message' => '用户名称已经被注册']);
            }
            $user->name = request('name');
        }
        if ($request->file('avatar')) {
            $path         = $request->file('avatar')->storePublicly(md5(\Auth::id() . time()));
            $user->avatar = "/storage/" . $path;
        }

        $user->save();

        return back();
    }

    public function sendReminderEmail()
    {
        $user = User::findOrFail('67');

//        return $this->dispatch((new SendReminderEmail($user))->onConnection('redis')->onQueue('email')); //onQueue 指定队列名称
        return $this->dispatch((new SendReminderEmail($user))->onConnection('database')->onQueue('email')); //onQueue 指定队列名称
    }
    public function qrcode()
    {
        //return QrCode::size(100)->generate('http://fpjtest.datarj.com/einv/mb?g=bqw&q=b249NDYmc2k9ZmIxZDUzNTgwNGM4ZjlkZjFjZDc1NjEyODgwY2MzNmI=');
        //QrCode::format('png')->size(200)->merge('/public/qrcodes/logo.png',.15)->generate('https://www.baidu.com',public_path('qrcodes/qrcode.png'));
        return base64_encode((new QrCode())->format('png')->size(200)->merge('/public/qrcodes/logo.png',.15)->generate('https://www.baidu.com'));

    }
    public function pdfToImage()
    {
        /*$im = new \Imagick(public_path('pdftoimage/test.pdf'));
        $im->setImageFormat('jpg');
        header('Content-Type: image/jpeg');
        echo $im;
        exit;*/
        $pathToPdf =  public_path('pdftoimage/test.pdf');
        $pdf = new \Spatie\PdfToImage\Pdf($pathToPdf);
        $saveImageUrl = public_path('pdftoimage/test.jpg');
        $pdf->saveImage($saveImageUrl);

        exit;
        var_dump($pdf->getNumberOfPages());
//        var_dump($pdf->setCompressionQuality(100)->saveImage($saveImageUrl));
        var_dump($pdf->saveImage($saveImageUrl));
    }
    //注入实例  一个具体类的类名 反射
    public function register(NexmoSender $smsSender)
    {

        $smsSender->send('{PHONE}', '{MESSAGE}');

        return dd($smsSender);
    }
    //注入接口类型 需要serviceProvider提供绑定关系
    public function register1(SmsSenderContract $smsSender)
    {
        $smsSender->send('{PHONE}', '{MESSAGE}');

        return dd($smsSender);
    }
    /*public function register2()
    {
        $smsSender = \App::make(SmsSenderContract::class);
        $smsSender->send('{PHONE}', '{MESSAGE}');

        return dd($smsSender);
    }*/
    //定义自己的facade
    public function myFacade()
    {
        Pay::test();
    }

}

