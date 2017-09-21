<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class WebAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller 注册和登录控制器
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     * 完成登录或注册后重定向到的位置，在这里配置
     * @var string
     */
    protected $redirectTo = '/web/index';
    //protected $redirectPath =  '/web/index';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //张善飞注释 源文件  $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->middleware('guest',['except'=>['getLogout','getRegister']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *		 验证注册请求
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'account' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *	注册验证成功后，创建一个新用户实例
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['username'],
            'account' => $data['account'],
            'password' => bcrypt($data['password']),
        	'addtime' => time(),
        ]);
    }
}
