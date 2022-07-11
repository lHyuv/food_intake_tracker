<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\FoodProperties;
use Validator;

class FoodController extends Controller
{
    //
    public function index(){
        $data = Food::with([
            'foodproperties',
         ])->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show_active(){
        $data = Food::with([
            'foodproperties',
         ])->where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show($id){
        $data = Food::with([
            'foodproperties',
         ])->find($id);

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function create(Request $request){
        
        $validator = Validator::make($request->all(), [
            //
            'food_name' => ['required','string', 'max:255'],
            //
        ]);

        if($validator->fails()){
            return ['message' => [$validator->errors()]];       
        }

        $data =  Food::create($request->all());
        //
        FoodProperties::create([
            'property' => 'VitaminA',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        FoodProperties::create([
            'property' => 'VitaminC',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        FoodProperties::create([
            'property' => 'VitaminD',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        FoodProperties::create([
            'property' => 'VitaminE',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        FoodProperties::create([
            'property' => 'Salt',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        FoodProperties::create([
            'property' => 'Sugar',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        FoodProperties::create([
            'property' => 'Fat',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        FoodProperties::create([
            'property' => 'Protein',
            'food_id' => $data->id,
            'amount' => 0,
        ]);
        
        //
        return [
            'message' => 'Successfully created',
            'data' => $data
        ];
    }

    public function update(Request $request, $id){
        $data = Food::findOrFail($id);
        $data->update($request->all());

        return [
            'message' => 'Successfully updated',
            'data' => $data
        ];  
    }

    public function delete(Request $request, $id){
        $data = Food::findOrFail($id);

        $data->update([
            'status' => 'Inactive'
        ]);
        $data->delete();
        //return $data;
        return [
            'message' => 'Successfully deleted'
        ];
    }


}
