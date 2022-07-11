<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyLimit;
use Validator;

class DailyLimitController extends Controller
{
    //
    public function index(){
        $data = DailyLimit::with([
            'users',
            'foodproperties',
         ])->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show_active(){
        $data = DailyLimit::with([
            'users',
            'foodproperties',
         ])->where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show($id){
        $data = DailyLimit::with([
            'users',
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
            'user_id' => ['required','string', 'max:255'],
            //
        ]);

        if($validator->fails()){
            return ['message' => [$validator->errors()]];       
        }

        $data =  DailyLimit::create($request->all());
        return [
            'message' => 'Successfully created',
            'data' => $data
        ];
    }

    public function update(Request $request, $id){
        $data = DailyLimit::findOrFail($id);
        $data->update($request->all());

        return [
            'message' => 'Successfully updated',
            'data' => $data
        ];  
    }

    public function delete(Request $request, $id){
        $data = DailyLimit::findOrFail($id);

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
