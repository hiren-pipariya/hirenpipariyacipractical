<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\UserDetail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string','alpha-dash','max:255', 'unique:user_details'],
            'mobile' => ['required', 'digits:12'],
            'gender' => ['required',  Rule::in(['male', 'female'])],
            'photo' => ['required',  'image' , 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['first_name']. " ".$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        self::userdetail($data,$user->id); // save user detail to user_details table
        return $user;
    }

    /**
     * Create a new user detail instance after a valid registration and .
     *
     * @param  array  $data
     * @return \App\UserDetail
     */

    private static function userdetail(array $data,$user_id){

        $file_path = 'public/user/'.$user_id.'/'.$data['user_name']; //create name of file and path of file

        $file_name = Storage::disk('local')->put($file_path, $data['photo']); // Store image in particular folder
        $userdata = array(
            'user_id'    => $user_id,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'user_name'  => $data['user_name'],
            'mobile'     => $data['mobile'],
            'gender'     => $data['gender'],
            'photo'      => $file_name
        );
        return UserDetail::create($userdata);
    }
}
