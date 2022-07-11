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
use App\Models\DailyLimit;

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
        //
        //Daily Limit Check
        $calorie = 2000;
        $sugar = 0;
        $salt = 0;
        $fat = 0;
        $age = $data['age'];
        //Calorie Check 
        if($data['gender'] == 'Male'){
            if($data['physical_activity'] == 'Sedentary'){

                if($age >= 2 && $age <= 3){
                    $calorie = 1000;
                }else if($age >= 4 && $age <= 5){
                    $calorie = 1200;
                }else if($age >= 6 && $age <= 8){
                    $calorie == 1400;
                }else if($age >= 9 && $age <= 10){
                    $calorie  = 1600;
                }else if($age >= 11 && $age <= 12){
                    $calorie = 1800;
                }else if($age >= 13 && $age <= 14){
                    $age = 2000;
                }else if($age == 15){
                    $calorie = 2200;
                }else if($age >= 16 && $age <= 18){
                    $calorie = 2400;
                }else if($age >= 19 && $age <= 20){
                    $calorie = 2600;
                }else if($age >= 21 && $age <= 40){
                    $calorie = 2400;
                }else if($age >= 41 && $age <= 60){
                    $calorie = 2200;
                }else if($age > 60){
                    $calorie = 2600; 
                }
            }else if($data['physical_activity'] == 'Moderate'){
                if($age >= 2 && $age <= 3){
                    $calorie = 1000;
                }else if($age >= 4 && $age <= 7){
                    $calorie = 1200;
                }else if($age >= 8 && $age <= 10){
                    $calorie == 1400;
                }else if($age >= 11 && $age <= 13){
                    $calorie  = 1600;
                }else if($age >= 14 && $age <= 18){
                    $calorie = 1800;
                }else if($age >= 19 && $age <= 25){
                    $age = 2000;
                }else if($age >= 26 && $age <= 50){
                    $calorie = 1800;
                }else if($age > 50){
                    $calorie = 1600;
                }
            }else if($data['physical_activity'] == 'High'){
                if($age == 2){
                    $calorie = 1000;
                }else if($age == 3){
                    $calorie = 1400;
                }else if($age >= 4 && $age <= 5){
                    $calorie == 1600;
                }else if($age >= 6 && $age <= 7){
                    $calorie  = 1800;
                }else if($age >= 8 && $age <= 9){
                    $calorie = 2000;
                }else if($age >= 10 && $age <= 11){
                    $age = 2200;
                }else if($age == 12){
                    $calorie = 2400;
                }else if($age == 13){
                    $calorie = 2600;
                }else if($age == 14){
                    $calorie = 2800;
                }else if($age == 15){
                    $calorie = 3000;
                }else if($age >= 16 && $age <= 18){
                    $age = 3200;
                }else if($age >= 19 && $age <= 35){
                    $age = 3000;
                }else if($age >= 36 && $age <= 55){
                    $age = 2800;
                }else if($age >= 56 && $age <= 65){
                    $age = 2600;
                }else if($age > 65){
                    $calorie = 3400;
                }
            }else{ //female
                if($data['physical_activity'] == 'Sedentary'){

                    if($age >= 2 && $age <= 3){
                        $calorie = 1000;
                    }else if($age >= 4 && $age <= 7){
                        $calorie = 1200;
                    }else if($age >= 8 && $age <= 10){
                        $calorie == 1400;
                    }else if($age >= 11 && $age <= 13){
                        $calorie  = 1600;
                    }else if($age >= 14 && $age <= 18){
                        $calorie = 1800;
                    }else if($age >= 19 && $age <= 25){
                        $age = 2000;
                    }else if($age >= 26 && $age <= 50){
                        $calorie = 1800;
                    }else if($age > 50){
                        $calorie = 1600;
                    }
                }else if($data['physical_activity'] == 'Moderate'){
                    if($age == 2){
                        $calorie = 1000;
                    }else if($age == 3){
                        $calorie = 1200;
                    }else if($age >= 4 && $age <= 6){
                        $calorie == 1400;
                    }else if($age >= 7 && $age <= 9){
                        $calorie  = 1600;
                    }else if($age >= 10 && $age <= 11){
                        $calorie = 1800;
                    }else if($age >= 12 && $age <= 18){
                        $age = 2000;
                    }else if($age >= 19 && $age <= 25){
                        $calorie = 2200;
                    }else if($age >= 26 && $age <= 50){
                        $calorie = 2000;
                    }else if($age > 50){
                        $calorie = 1600;
                    }
                }else if($data['physical_activity'] == 'High'){
                    if($age == 2){
                        $calorie = 1000;
                    }else if($age >= 3 && $age <= 4){
                        $calorie = 1400;
                    }else if($age >= 5 && $age <= 6){
                        $calorie == 1600;
                    }else if($age >= 7 && $age <= 9){
                        $calorie  = 1800;
                    }else if($age >= 10 && $age <= 11){
                        $calorie = 2000;
                    }else if($age >= 12 && $age <= 13){
                        $age = 2200;
                    }else if($age >= 14 && $age <= 18){
                        $calorie = 2000;
                    }else if($age >= 19 && $age <= 25){
                        $calorie = 2200;
                    }else if($age >= 26 && $age <= 50){
                        $calorie = 2000;
                    }else if($age > 50){
                        $calorie = 1800;
                    }
                }
            }
        }
        
        //Calorie Check:end

        //Health Issue Check
        if($data['healthissues_name']){
            foreach($data['healthissues_name'] as $key => $value) {
                if($key == 'Highblood'){
                    $fat = $calories * 0.27; 
                    $salt = 2000; //in mg
                }else if($key == 'Salt'){
                    $salt = 2000; //in mg
                }else if($key == 'Sugar'){
                    $sugar = 30; //in g
                    if($data['gender'] == 'Male' || $data['gender'] == 'male'){
                        if($calorie > 2500){
                            $calorie = 2500;
                        }
                    }else{
                        if($calorie > 2000){
                            $calorie = 2000;
                        }
                    }
                }else{
                    $salt = 2000; //in mg
                    $sugar = $calorie * 0.1;
                    $fat = $calorie * 0.1;
                }
            }
        }else{
            $salt = 2300; //in mg
            $sugar = $calorie * 0.1;
            $fat = $calorie * 0.1;
        }
        //Health Issue Check:end 
        if($data['gender'] == 'Male' || $data['gender'] == 'male'){
            DailyLimit::create([
                'vitamin_a' => 700, // µg
                'vitamin_c' => 70,
                'vitamin_e' => 10, //mg
                //
                'salt' => $salt,
                'sugar' => $sugar, 
                'fat' => $fat, 
                'protein' => 155.92, //g
                'vitamin_d' => 5, // µg
                'calorie' => $calorie,
                'user_id' => $user->id,
            ]);
        }else if($data['gender'] == 'Female' || $data['gender'] == 'female'){
            DailyLimit::create([
                'vitamin_a' => 600, // µg
                'vitamin_c' => 60,
                'vitamin_e' => 10, //mg
                //
                'salt' => $salt,
                'sugar' => $sugar,  
                'fat' => $fat, 
                'protein' => 155.92, //g
                'vitamin_d' => 5, // µg
                'calorie' => $calorie,
                'user_id' => $user->id,
            ]);    
        }

        
        //
        $userissue = null;


        $token = $user->createToken('auth_token')->plainTextToken;
            
        if($data['healthissues']){

            foreach($data['healthissues'] as $key => $value) {
                
                // $key will contain your article id
                $userissue = UserIssues::create([
                    'user_id' => $user->id,
                    'healthissue_id' => $key,
                ]);
            }
        }
        

        //Save Session

        session()->put('token',$token);
        session()->put('user_id',$user->id);
        session()->save();

        //Save Session:end 
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
