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
        $data = Food::get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show_active(){
        $data = Food::where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show($id){
        $data = Food::find($id);

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
            'property_name' => 'VitaminA',
        ]);
        FoodProperties::create([
            'property_name' => 'VitaminC',
        ]);
        FoodProperties::create([
            'property_name' => 'VitaminD',
        ]);
        FoodProperties::create([
            'property_name' => 'VitaminE',
        ]);
        FoodProperties::create([
            'property_name' => 'Salt',
        ]);
        FoodProperties::create([
            'property_name' => 'Sugar',
        ]);
        FoodProperties::create([
            'property_name' => 'Fat',
        ]);
        FoodProperties::create([
            'property_name' => 'Protein',
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
