<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//
use App\Models\HealthIssues;
use App\Models\UserIssues;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //added fields 
            'role_id' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            //added fields 
            'physical_activity' => $data['physical_activity'],
            'gender' => $data['gender'],
            'age' => $data['age'],
            'weight' => $data['weight'],
            'role_id' => $data['role_id'],
        ]);

        $userissue = null;

        if($data['healthissues']){

            foreach($data['healthissues'] as $key => $value) {
                // $key will contain your article id
                $userissue = UserIssues::create([
                    'user_id' => $user->id,
                    'healthissue_id' => $key,
                ]);
            }
        }


        return $user;
    }

    protected function showRegistrationForm()
    {
        $roles = DB::table('roles')->where('status', 'Active')->get();
        $healthissues = DB::table('health_issues')->where('status', 'Active')->get();
        return view('auth.register', [
            'roles' =>  $roles,
            'healthissues' => $healthissues,
        ]);

    }
}
