<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthIssues;
use Validator;

class HealthIssuesController extends Controller
{
    //
    public function index(){
        $data = HealthIssues::get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show_active(){
        $data = HealthIssues::where('status','Active')->get();

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function show($id){
        $data = HealthIssues::find($id);

        return [
            'message' => 'Successfully retrieved',
            'data' => $data
        ];
    }

    public function create(Request $request){
        
        $validator = Validator::make($request->all(), [
            //
            'name' => ['required','string', 'max:255'],
            //
        ]);

        if($validator->fails()){
            return ['message' => [$validator->errors()]];       
        }

        $data =  HealthIssues::create($request->all());
        return [
            'message' => 'Successfully created',
            'data' => $data
        ];
    }

    public function update(Request $request, $id){
        $data = HealthIssues::findOrFail($id);
        $data->update($request->all());

        return [
            'message' => 'Successfully updated',
            'data' => $data
        ];  
    }

    public function delete(Request $request, $id){
        $data = HealthIssues::findOrFail($id);

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
