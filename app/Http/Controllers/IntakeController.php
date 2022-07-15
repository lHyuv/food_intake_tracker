<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intake;
use Validator;

class IntakeController extends Controller
{
    //
    public function index(){
        $data = Intake::with([
            'foods',
            'users',
         ])->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show_active(){
        $data = Intake::with([
            'foods',
            'users',
         ])->where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show($id){
        $data = Intake::with([
            'foods',
            'users',
         ])->find($id);

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function create(Request $request){
  
            $validator = Validator::make($request->all(), [
                //
                'user_id' => ['required','string', 'max:255'],
                'serving' => ['required'],
     
                //
            ]);
    
            if($validator->fails()){
                return ['message' => [$validator->errors()]];       
            }
            
            //$data =  Intake::create($request->all());
            $data =  Intake::create([
                'user_id' => $request['user_id'],
                'food_id' => $request['food_id'],
                'serving' => $request['serving'],
                'type' => 'Local',
                'ext_food_id' => $request['ext_food_id'],
                'ext_food_name' => $request['ext_food_name'],
                'ext_vitamin_a' => $request['ext_vitamin_a'],
                'ext_vitamin_c'=> $request['ext_vitamin_c'],
                'ext_vitamin_d'=> $request['ext_vitamin_d'],
                'ext_vitamin_e'=> $request['ext_vitamin_e'],
                'ext_fat'=> $request['ext_fat'],
                'ext_protein'=> $request['ext_protein'],
                'ext_salt'=> $request['ext_salt'],
                'ext_sugar'=> $request['ext_sugar'],
            ]);
            
         

            return [
                'message' => 'Successfully created',
                'data' => $data
            ];
        

    }

    public function update(Request $request, $id){
        $data = Intake::findOrFail($id);
        $data->update($request->all());

        return [
            'message' => 'Successfully updated',
            'data' => $data
        ];  
    }

    public function delete(Request $request, $id){
        $data = Intake::findOrFail($id);

        $data->update([
            'status' => 'Inactive'
        ]);
        $data->delete();
        //return $data;
        return [
            'message' => 'Successfully deleted'
        ];
    }

    public function show_user($id){
        $data = Intake::with([
            'foods',
            'users',
         ])->where('user_id',$id)->where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

}
