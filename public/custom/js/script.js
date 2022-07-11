let global_ctr = 0;
let tr = 'tr';

const notification = (type, title, message) => {

	toastr.options = {
		preventDuplicates: true,
		preventOpenDuplicates: true,
		positionClass: 'toast-top-center',
        closeButton: true,
        newestOnTop: true,
        progressBar: true,
	};

	return toastr[type](message, title);
};

const showElement = (type, value, mode) =>{
 
    let selector = "";

    $('input').val('');
    if(type == "id"){
        selector = "#";
    }else if(type == "class"){
        selector = ".";
    }

    if(mode == "show"){
        $(selector + value).css('display', 'block');
    }else if(mode == "flex"){
        $(selector + value).css('display', 'flex');
    }else{
        $(selector + value).css('display', 'none');
    }
};

const submitForm = (url,method, data, action) =>{
    $.ajax({
        url: url,
        method: method,
        data: data,
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
        },
        success: (data)=>{
            console.log(data);
            action();
            notification('success','','Submitted!');
        },
        error: ({responseJson})=>{
            console.log(responseJson);
            notification('error','','Something went wrong');
        }
    })
};



const submitIntake = () =>{

    $('#intake_table tbody').find('tr').each((i,val)=>{

        submitForm('api/v1/intakes','POST',{
            'user_id' : sessionStorage.getItem('user_id'),
            'serving' : $(val).find('td').find('input').val(),
            'food_id' : $(val).find('td').find('select').val()
        }, ()=>{
         
        })
    });


   $('#intake_table tbody').find('tr').each((i,val)=>{
        if(i != 0){
            $(val).find('td').remove();
        }
        
      
    });
    $('input').val('');
    notification('success','','Submitted!');

};

const loadFoods = (baseURL) =>{

    $.ajax({
        url: baseURL + '/api/v1/foods',
        method: 'GET',
        headers: {
            'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
        },
        success: (data)=>{
         //   let code = ``;
        $('select').find('option').each((i,val)=>{
            $(val).remove();
        })
         let code = `<option>BLAHBLAH</option>`;
            data.data.map((val)=>{
                code += `<option id = '${val.id}'>${val.food_name}</option>`;
            }).join("");
            $('#intake_food_id_').append(code);
            $('#set_food').append(code);
            
        },
        error: ({responseJson})=>{
         //   console.log(responseJson);
        }
    })
};

//
const createChart = (baseURL) =>{

    let foods = new Array();
    let servings = new Array();
    let property = new Array();
    let property_values = new Array();
    
    $.ajax({
        url: baseURL + '/api/v1/intakes/user/' + sessionStorage.getItem('user_id'),
        method: 'GET',
        headers: {
            'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
        },
        success: (data)=>{
           
            data.data.map((val)=>{
            
                if(foods.includes(val.food_id)){
                    servings[foods.indexOf(val.food_id)] = 
                    parseFloat(servings[foods.indexOf(val.food_id)]) + parseFloat((val.serving));
                }else{
                    foods.push(val.food_id);
                    servings.push(val.serving);
                }
            
              
            });

            foods.map((val,i)=>{
                $.ajax({
                    url: baseURL + '/api/v1/food_properties',
                    method: 'GET',
                    headers: {
                        'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
                    },
                    success: (data2)=>{
                     
                        data2.data.map((val2,k)=>{
      
                            if(val2.food_id == val){
                             


                                if(property.includes(val2.property)){
                                    property_values[property.indexOf(val2.property)] =
                                    parseFloat(property_values[property.indexOf(val2.property)] + 
                                    (servings[foods.indexOf(val)] * (val2.amount)));
                                 
                                }else{
                                    property.push(val2.property);
                                    property_values.push(
                                    (servings[foods.indexOf(val)] * (val2.amount))); 
                                }
                            }
                        });
                    
                        if(i == foods.length - 1){
                        
// graph chart
let graphChartCanvas = $('#chart-1').get(0).getContext('2d')
            
            
let graphChartData = {
    labels: property,
    datasets: [
    {
        label: 'Vitamins and Minerals based on Intake',
        fill: false,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: 'rgba(54, 162, 235)',//'gray',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        pointRadius: 3,

        data: property_values
    }
    ]
}

let graphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
    display: false
    },
    scales: {
    y: {  
        min: 0,
        suggestedMax: 10,
        step: 1,

    },
    x: {  
        min: 0,
        
    },

    }
}


let graphChart = new Chart(graphChartCanvas, { 
    type: 'bar', //'line',
    data: graphChartData,
    options: graphChartOptions
})
//chart:end
                        }
                    }
                })
            })

 
        }

    });
 
};

const setProgress = (baseURL) =>{
    let vitamin_a = 0;
    let vitamin_c = 0;
    let vitamin_d = 0;
    let vitamin_e = 0;
    let protein = 0;
    let salt = 0;
    let sugar = 0;
    let fat = 0;
    $.ajax({ 
        url: baseURL + '/api/v1/intakes/user/' + sessionStorage.getItem('user_id'),
        method: 'GET',
        headers: {
            'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
        },
        success: (data)=>{
            
            data.data.map((val,i)=>{
  
                if(moment(val.created_at).format("MMM Do YYYY") == moment(new Date()).format("MMM Do YYYY")){
                $.ajax({
                    url: baseURL + '/api/v1/food_properties/food/' + val.food_id,
                    method: 'GET',
                    headers: {
                        'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
                    },
                    success: (data2)=>{
                        data2.data.map((val)=>{
                            switch(val.property.toLowerCase().trim()){
                                case 'vitamina':
                                vitamin_a = parseFloat(vitamin_a + val.amount);
                                break;
                                case 'vitaminc':
                                vitamin_c = parseFloat(vitamin_c + val.amount);
                                break;
                                case 'vitamind':
                                vitamin_d = parseFloat(vitamin_d + val.amount);
                                break;
                                case 'vitamine':
                                vitamin_e = parseFloat(vitamin_e + val.amount);
                                break;
                                case 'salt':
                                salt = parseFloat(salt + val.amount);
                                break;
                                case 'sugar':
                                sugar = parseFloat(sugar + val.amount);
                                break;
                                case 'protein':
                                protein = parseFloat(protein + val.amount);
                                break;

                                case 'fat':
                                fat = parseFloat(fat + val.amount);
                                break;
                            }

                        })
                    
                        if(i + 1 == data.data.length){
                            
                            $.ajax({
                                url: baseURL + '/api/v1/daily_limit/user/' + sessionStorage.getItem('user_id'),
                                // url: baseURL + '/api/v1/daily_limit/',
                                method: 'GET',
                                headers: {
                                    'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
                                },
                                success: (data3)=>{
                                    if(vitamin_a > data3.data[0].vitamin_a && data3.data[0].vitamin_a != 0){
                                        $('#vitamin_a_progress').addClass('bg-danger');
                                    }
                                    if(vitamin_c > data3.data[0].vitamin_c && data3.data[0].vitamin_c != 0){
                                        $('#vitamin_c_progress').addClass('bg-danger');
                                    }
                                    if(vitamin_d > data3.data[0].vitamin_d && data3.data[0].vitamin_d != 0){
                                        $('#vitamin_d_progress').addClass('bg-danger');
                                    }
                                    if(vitamin_e > data3.data[0].vitamin_e && data3.data[0].vitamin_e != 0){
                                        $('#vitamin_e_progress').addClass('bg-danger');
                                    }
                                    if(salt > data3.data[0].salt && data3.data[0].salt != 0){
                                        $('#salt_progress').addClass('bg-danger');
                                    }
                                    if(sugar > data3.data[0].sugar && data3.data[0].sugar != 0){
                                        $('#sugar_progress').addClass('bg-danger');
                                    }
                                    if(protein > data3.data[0].protein && data3.data[0].protein != 0){
                                        $('#protein_progress').addClass('bg-danger');
                                    }
                                    if(fat > data3.data[0].fat && data3.data[0].fat != 0){
                                        $('#fat_progress').addClass('bg-danger');
                                    }
                                    //
                                    if(data3.data[0].vitamin_a != 0){
                                        
                                        $('#vitamin_a_progress').css('width', 
                                        String(parseFloat( vitamin_a/data3.data[0].vitamin_a) * 100) + "%");
                                        $('#vitamin_a_text').html(`${vitamin_a} / ${data3.data[0].vitamin_a}`);
                                    }else{
                                        $('#vitamin_a_progress').css('width', 
                                         "100%");   
                                         $('#vitamin_a_text').html(`${vitamin_a}`); 
                                    }

                                    //
                                    if(data3.data[0].vitamin_c != 0){
                
                                        $('#vitamin_c_progress').css('width', 
                                        String(parseFloat( vitamin_c/data3.data[0].vitamin_c) * 100) + "%");
                                        $('#vitamin_c_text').html(`${vitamin_c} / ${data3.data[0].vitamin_c}`);
                                    }else{
                                        $('#vitamin_c_progress').css('width', 
                                         "100%");    
                                         $('#vitamin_c_text').html(`${vitamin_c}`); 
                                    }

                                    //
                                    if(data3.data[0].vitamin_d != 0){
                
                                        $('#vitamin_d_progress').css('width', 
                                        String(parseFloat( vitamin_d/data3.data[0].vitamin_d) * 100) + "%");
                                        $('#vitamin_d_text').html(`${vitamin_d} / ${data3.data[0].vitamin_d}`);
                                    }else{
                                        $('#vitamin_c_progress').css('width', 
                                         "100%");    
                                         $('#vitamin_d_text').html(`${vitamin_d}`); 
                                    }

                                    
                                    //
                                    if(data3.data[0].vitamin_e != 0){
                
                                        $('#vitamin_e_progress').css('width', 
                                        String(parseFloat( vitamin_e/data3.data[0].vitamin_e) * 100) + "%");
                                        $('#vitamin_e_text').html(`${vitamin_e} / ${data3.data[0].vitamin_e}`);
                                    }else{
                                        $('#vitamin_e_progress').css('width', 
                                         "100%");    
                                         $('#vitamin_e_text').html(`${vitamin_e}`); 
                                    }
                                    //
                                    if(data3.data[0].vitamin_e != 0){
                
                                        $('#salt_progress').css('width', 
                                        String(parseFloat( salt/data3.data[0].salt) * 100) + "%");
                                        $('#salt_text').html(`${salt} / ${data3.data[0].salt}`);
                                    }else{
                                        $('#salt_progress').css('width', 
                                         "100%");    
                                         $('#salt_text').html(`${salt}`); 
                                    }

                                   //
                                   if(data3.data[0].sugar != 0){
                
                                    $('#sugar_progress').css('width', 
                                    String(parseFloat( sugar/data3.data[0].sugar) * 100) + "%");
                                    $('#sugar_text').html(`${sugar} / ${data3.data[0].sugar}`);
                                    }else{
                                        $('#sugar_progress').css('width', 
                                        "100%");    
                                        $('#sugar_text').html(`${sugar}`); 
                                    }

                                   //
                                   if(data3.data[0].fat != 0){
                
                                    $('#fat_progress').css('width', 
                                    String(parseFloat( fat/data3.data[0].fat) * 100) + "%");
                                    $('#fat_text').html(`${fat} / ${data3.data[0].fat}`);
                                    }else{
                                        $('#fat_progress').css('width', 
                                        "100%");    
                                        $('#fat_text').html(`${fat}`); 
                                    }

                                   //
                                   if(data3.data[0].protein != 0){
                
                                    $('#protein_progress').css('width', 
                                    String(parseFloat( fat/data3.data[0].protein) * 100) + "%");
                                    $('#protein_text').html(`${protein} / ${data3.data[0].protein}`);
                                    }else{
                                        $('#protein_progress').css('width', 
                                        "100%");    
                                        $('#protein_text').html(`${protein}`); 
                                    }
                                }
                            })
                        }
                    }
                })
                }
            });


    
        }
    })
};