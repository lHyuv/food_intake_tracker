<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Intake;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $foods = Food::where('status','Active')->get();
        $intakes = Intake::where('status','Active')->where('user_id',Auth::user()->id)->get();
        return view('home',[
            'foods' => $foods,
            'intakes' => $intakes,
        ]);
    }
}
