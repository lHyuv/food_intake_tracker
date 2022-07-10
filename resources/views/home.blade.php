@extends('layouts.header')

@section('content')
<div class="container">
    <!--Create Food--> 
    <div class="row justify-content-center mt-3" id = "add_food" style = "display:none;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Food</div>

                <div class="card-body">

             
                        <label>Food Name</label>
                        <input type="text" name = "" id = "" class = "form-control">
                        <button class = "btn btn-primary mt-2" type="submit" 
                        onclick = ""
                        >Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--Create Food:end--> 
        <!--Set Food Properties--> 
        <div class="row justify-content-center mt-3" id = "set_food_properties" style = "display:none;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Set Food Properties</div>

                <div class="card-body">

             
                        <label>Food Name</label>
                        <select name="" id="" class = "form-control">

                        </select>

                        <label>Property <sub> e.g. Vitamin</sub></label>
                        <input type="text" name = "" id = "" class = "form-control">
                        <button class = "btn btn-primary mt-2" type="submit" 
                        onclick = ""
                        >Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--Set Food Properties:end--> 
    <!--View Intake--> 
        <div class="row justify-content-center mt-3" id = "view_intake" style = "display:none;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">View Intake</div>

                <div class="card-body">

              
                    <table class = "table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Food
                                </th>
                                <th>
                                    Amount
                                </th>
                                <th>
                                    Intake
                                </th>
                                <th>
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--View Intake:end--> 
        <!--View Results--> 
        <div class="row justify-content-center mt-3" id = "view_results" style = "display:none;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">View Results</div>

                <div class="card-body">

              

                </div>
            </div>
        </div>
    </div>
    <!--View Results:end--> 
    <div class="row justify-content-center mt-3" id = "add_intake">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Intake Table</div>

                <div class="card-body">
                    <button class = "btn btn-primary"
                    onclick = ""
                    >Add Intake <i class = "fas fa-plus"></i> </button>

                    <table class = "table table-striped">
                        <thead>
                            <tr>
                                <th width = "50%">
                                    Food
                                </th>
                                <th width = "50%">
                                    Serving
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="" id="" class = "form-control">

                                    </select>
                                </td>
                                <td>
                                    <input type="number" name = "" id = "" class = "form-control">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class = "btn btn-primary mt-2" type="submit" 
                    onclick = ""
                    >Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
