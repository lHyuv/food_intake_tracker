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
                        <input type="text" name = "food_name" id = "add_food_name" class = "form-control">
                        <button class = "btn btn-primary mt-2" type="submit" 
                        onclick = "
                        submitForm(
                            '{{ URL::to('/') }}/api/v1/foods',
                            'POST', 
                            {
                                'food_name' :   $('#add_food_name').val(),
                            },
                          
                            function(){
                                notification('success','','Submitted!');
                            }
                            );
                            //
                            showElement('','.row.justify-content-center.mt-3','none');
                            showElement('id','add_intake','flex');
                            loadFoods('{{ URL::to('/') }}');
                        "
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
                        <select name="food_id" id="set_food" class = "form-control" required>
                        @foreach($foods as $f)
                                    <option  class = "local_food" value="{{$f->id}}">{{$f->food_name}}</option>
                        @endforeach
                        </select>
                            
                        <label>Property <sub> e.g. Vitamin</sub></label>
                        <input type="text" name = "property" id = "property" class = "form-control">

                        <label>Amount</label>
                        <input type="number" name = "amount" id = "amount" step = "0.01" class = "form-control">

                        <button class = "btn btn-primary mt-2" type="submit" 
                        onclick = "                        submitForm(
                            '{{ URL::to('/') }}/api/v1/food_properties',
                            'POST', 
                            {
                                'food_id' :   $('#set_food').val(),
                                'property' :   $('#property').val(),
                                'amount' : $('#amount').val(),
                            },
                          
                            function(){
                                notification('success','','Submitted!');
                            }
                            );
                            //
                            showElement('','.row.justify-content-center.mt-3','none');
                            showElement('id','add_intake','flex');
                            loadFoods('{{ URL::to('/') }}');
                        "
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

              
                    <table class = "table table-striped" id = 'intake_history_table'>
                        <thead>
                            <tr>
                                <th>
                                    Food
                                </th>
                                <th>
                                    Amount
                                </th>
                                <th>
                                    Created At
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($intakes as $i)
                                <tr>
                                    @if(isset( $i->foods))
                                    <td> {{ $i->foods->pluck('food_name')[0]}} </td>
                                    @else
                                    <td> {{ $i->ext_food_name}} </td>
                                    @endif
                                    <td> {{$i->serving}} kg </td>
                                    <td> {{$i->created_at->diffForHumans()}}</td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--View Intake:end--> 
        <!--View Results--> 
        <div class="row justify-content-center mt-3" id = "view_results" style = "display:none;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">View Results</div>

                <div class="card-body">
                <div class = "row">
                <div class = "col-md-8">
                <canvas class="chart" id="chart-1" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                </div>
                <div class = "col-md-4">
                            <!---->
 
                    <label>Vitamin A</label>
                    <div class="progress mb-3">

                      <div id = 'vitamin_a_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "vitamin_a_text">0/0</span></div>
                    </div>
                    <label>Vitamin C</label>
                    <div class="progress mb-3">

                      <div id = 'vitamin_c_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "vitamin_c_text">0/0</span></div>
                    </div>
                    <label>Vitamin D</label>
                    <div class="progress mb-3">

                      <div id = 'vitamin_d_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "vitamin_d_text">0/0</span></div>
                    </div>
                    <label>Vitamin E</label>
                    <div class="progress mb-3">

                      <div id = 'vitamin_e_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "vitamin_e_text">0/0</span></div>
                    </div>
                    <label>Protein</label>
                    <div class="progress mb-3">

                      <div id = 'protein_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "protein_text">0/0</span></div>
                    </div>
                    <label>Fat</label>
                    <div class="progress mb-3">

                      <div id = 'fat_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "fat_text">0/0</span></div>
                    </div>
                    <label>Salt</label>
                    <div class="progress mb-3">

                      <div id = 'salt_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "salt_text">0/0</span></div>
                    </div>
                    <label>Sugar</label>
                    <div class="progress mb-3">

                      <div id = 'sugar_progress' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id = "sugar_text">0/0</span></div>
                    </div>
                 
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--View Results:end--> 
    <div class="row justify-content-center mt-3" id = "add_intake">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Intake Table
                </div>

                <div class="card-body">
                    <button class = "btn btn-primary"
                    onclick = 'global_ctr++; $("#first_row").append( 
                    `<tr>
                                <td>
                                    <select required name="food_id" id="intake_food_id_${global_ctr}" class = "form-control">
                                    @foreach($foods as $f)
                                    <option class = "local_food" value="{{$f->id}}">{{$f->food_name}}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input required type="number" name = "serving" id = "intake_serving_${global_ctr}" class = "form-control">
                                </td>
                                <td>
                                <button class = "btn"
                                   onclick = "$(this).closest(tr).remove();"
                                   ><small> <i class = "fas fa-times"></i> </small></button>
                                </td>
                            </tr>
                    "`);
                    $("select").select2({
                            width: "100%",
                           templateSelection: formatSelect2,
                           templateResult: formatSelect2,
                     });
                    '
                    >Add Intake <i class = "fas fa-plus"></i> </button>

                    <table class = "table table-striped" id = "intake_table">
                        <thead>
                            <tr>
                                <th width = "50%">
                                    Food
                                </th>
                                <th width = "30%">
                                    Serving <small>(in kg) </small>
                                </th>
                                <th width = "20%">
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody id = "first_row">
                            <tr >
                                <td>
                                    <select required name="food_id" id="intake_food_id_" class = "form-control">
                                    @foreach($foods as $f)
                                    <option   value="{{$f->id}}" class = "local_food">{{$f->food_name}}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input   required type="number" name = "serving" id = "intake_serving_" class = "form-control">
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class = "btn btn-primary mt-2" type="submit" 
                    onclick = "submitIntake();"
                    >Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  sessionStorage.setItem('token', '{{ session("token") }}');
  sessionStorage.setItem('user_id', '{{ session("user_id") }}');
//

Swal.fire({
                    text: 'Loading...',
                    showConfirmButton: false,
                    icon: 'info',
                    timer: 20000,
                    allowOutsideClick: false,
                    didOpen: function(){
                        loadFoods('{{ URL::to('/') }}');
                        
                        let ctr = 0;
                        while(ctr <= 30){
                            loadFromExtAPI("{{env('EXT_API_URL');}}","{{env('EXT_API_KEY');}}", ctr,'{{ URL::to('/') }}' );
                            ctr++;
                        }
                        


                      
                    }
                
}).then(()=>{
    $('select').select2({
                            width: "100%",
                           templateSelection: formatSelect2,
                           templateResult: formatSelect2,
     });
})


</script>
<style>
    .select2-results__option[aria-label = 'Unsafe']{
	color: red;
  
}
</style>
@endsection
