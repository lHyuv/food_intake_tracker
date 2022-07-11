<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodProperties;
use Validator;

class FoodPropertiesController extends Controller
{
    //
    public function index(){
        $data = FoodProperties::with([
            'foods'
         ])->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show_active(){
        $data = FoodProperties::with([
            'foods'
         ])->where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show($id){
        $data = FoodProperties::with([
            'foods'
         ])->find($id);

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function create(Request $request){
        
        $validator = Validator::make($request->all(), [
            //
            'property' => ['required','string', 'max:255'],
            'food_id' => ['required','string', 'max:255'],
            'amount' => ['required'],
            //
        ]);

        if($validator->fails()){
            return ['message' => [$validator->errors()]];       
        }

        $data =  FoodProperties::create($request->all());
        return [
            'message' => 'Successfully created',
            'data' => $data
        ];
    }

    public function update(Request $request, $id){
        $data = FoodProperties::findOrFail($id);
        $data->update($request->all());

        return [
            'message' => 'Successfully updated',
            'data' => $data
        ];  
    }

    public function delete(Request $request, $id){
        $data = FoodProperties::findOrFail($id);

        $data->update([
            'status' => 'Inactive'
        ]);
        $data->delete();
        //return $data;
        return [
            'message' => 'Successfully deleted'
        ];
    }

    public function show_food($id){
        $data = FoodProperties::with([
            'foods',

         ])->where('food_id',$id)->where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }
}
