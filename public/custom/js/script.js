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
        error: (responseJson)=>{
            console.log(responseJson);
            notification('error','','Something went wrong');
        }
    })
};


const formatSelect2 = (icon) =>{
 

    if(icon && icon.element){
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    }
  
};

const submitIntake = () =>{

    $('#intake_table tbody').find('tr').each((i,val)=>{
 
  
      let data = '';
      if($(val).find('td').find('select option:selected').attr('class') == 'local_food'){
        data ={
            'user_id' : sessionStorage.getItem('user_id'),
            'serving' : $(val).find('td').find('input').val(),
            'food_id' : $(val).find('td').find('select').val(),

        }
      }else{
        let nutrients = [0,0,0,0,0,0,0,0];
        jQuery.parseJSON($(val).find('td').find('select').val()).foodNutrients.map((val)=>{
            if(val.name.includes('Vitamin A')){
                nutrients[0] = parseFloat(val.amount);
            }else if(val.name.includes('Vitamin C')){
                nutrients[1] = parseFloat(val.amount);
            }else if(val.name.includes('Vitamin D')){
                nutrients[2] = parseFloat(val.amount);
            }else if(val.name.includes('Vitamin E')){
                nutrients[3] = parseFloat(val.amount);
            }else if(val.name.includes('Sodium')){
                nutrients[4] = parseFloat(val.amount);
            }else if(val.name.includes('Sugar')){
                nutrients[5] = parseFloat(val.amount);
            }else if(val.name.includes('Lipid')){
                nutrients[6] = parseFloat(val.amount);
            }else if(val.name.includes('Protein')){
                nutrients[7] =parseFloat( val.amount);
            }
        })
        data ={
            'user_id' : sessionStorage.getItem('user_id'),
            'serving' : $(val).find('td').find('input').val(),
            'ext_food_id' : jQuery.parseJSON($(val).find('td').find('select').val()).fdcId,
            'ext_food_name' : $(val).find('td').find('select option:selected').text().trim(),
            'ext_vitamin_a' :  nutrients[0],
            'ext_vitamin_c' :  nutrients[1],
            'ext_vitamin_d' : nutrients[2],
            'ext_vitamin_e' : nutrients[3],
            'ext_protein' :  nutrients[4],
            'ext_salt' : nutrients[5],
            'ext_sugar' :  nutrients[6],
            'ext_fat' : nutrients[7],
        }

      }
 
        submitForm('api/v1/intakes','POST',data, ()=>{
         
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
        url:  baseURL + '/api/v1/daily_limit/user/' + sessionStorage.getItem('user_id'),
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
        },

        success: (data0)=>{ 
            //
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
            let code = ``;
            let unsafe = ``;
            let safe = ``;
            let ctr = 0;
                data.data.map((val)=>{
          
               
                

                //
                $.ajax({
                    url: baseURL + '/api/v1/food_properties/food/' + val.id,
                    method: 'GET',
                    headers: {
                        'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
                    },
                    success: (data2)=>{
                    //Food Constraint Check
                    let check = 0;

                    if(typeof(data2.data) != 'undefined' && data2.data != null && data2.data.length > 0){
                    data2.data.map((val2)=>{
                   
                        if(val2.property.includes('VitaminA') || val2.property.includes('Vitamin A')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].vitamin_a){
                                    check = 1;
                                }
                            }
                        }else if(val2.property.includes('VitaminC') || val2.property.includes('Vitamin C')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].vitamin_c){
                                    check = 1;
                                }
                            }
                        }else if(val2.property.includes('VitaminD') || val2.property.includes('Vitamin D')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].vitamin_d){
                                    check = 1;
                                }
                            }
                        }else if(val2.property.includes('VitaminE') || val2.property.includes('Vitamin E')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].vitamin_e){
                                    check = 1;
                                }
                            }
                        }else if(val2.property.includes('Salt')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].salt){
                                    check = 1;
                                }
                            }
                        }else if(val2.property.includes('Sugar')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].sugar){
                                    check = 1;
                                }
                            }
                        }else if(val2.property.includes('Fat')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].fat){
                                    check = 1;
                                }
                            }
                        }else if(val2.property.includes('Protein')){
                            if(data0.data.length > 0){
                                if(parseFloat(val2.amount) > data0.data[0].protein){
                                    check = 1;
                                }
                            }
                        }


                    }).join("");
                    if(check == 1){
                        //&#xf071
                       unsafe += `<option class = "local_food text-danger" id = '${val.id}' data-icon = 'fa-skull-crossbones' > ${val.food_name} </option>`;
                    }else{
                     
                        safe += `<option class = "local_food" id = '${val.id}'>${val.food_name}</option>`;
                    }
                    }else{
                        safe += `<option class = "local_food" id = '${val.id}'>${val.food_name}</option>`;
                    }
                    //Food Constraint Check:end

                //
                if(ctr + 1 == data.data.length){
                    code = `<optgroup label = 'Safe'>` + safe + `</optgroup><optgroup label = 'Unsafe'>` + unsafe + `</optgroup>`
                   
                    $('#intake_food_id_').append(code);
                    $('#set_food').append(code);
                    }
                    ctr++;
                    
                    }
                })


            })

            //


            
            },
            error: ({responseJson})=>{
            //   console.log(responseJson);
            }
        })
    //
    }
    })
};

//
const createChart = (baseURL) =>{

    let foods = new Array();
    let servings = new Array();
    let property = ['VitaminA','VitaminC','VitaminD','VitaminE','Salt','Sugar','Fat','Protein'];
    let property_values = [0,0,0,0,0,0,0,0];
   
    $.ajax({
        url: baseURL + '/api/v1/intakes/user/' + sessionStorage.getItem('user_id'),
        method: 'GET',
        headers: {
            'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
        },
        success: (data)=>{
           
            data.data.map((val)=>{

                if(moment(val.created_at).format("MMM Do YYYY") == moment(new Date()).format("MMM Do YYYY")){
                if(val.food_id != null){
                    
                    if(foods.includes(val.food_id)){
                        servings[foods.indexOf(val.food_id)] = 
                        parseFloat(servings[foods.indexOf(val.food_id)]) + parseFloat((val.serving));
                    }else{
                        foods.push(val.food_id);
                        servings.push(val.serving);
                    }
                }else if(val.food_id == null){

                    foods.push(val.ext_food_name);
                    servings.push(val.serving);

                            property_values[0] += val.ext_vitamin_a ? parseFloat(val.ext_vitamin_a * val.serving) : 0;
                            
                            property_values[1] += val.ext_vitamin_c ? parseFloat(val.ext_vitamin_c * val.serving) : 0;
                        
                            property_values[2] += val.ext_vitamin_d ? parseFloat(val.ext_vitamin_d * val.serving) : 0;
                            
                            property_values[3] += val.ext_vitamin_e ? parseFloat(val.ext_vitamin_e * val.serving) : 0;
                
                            property_values[4] += val.ext_salt ? parseFloat(val.ext_salt * val.serving) : 0;
                    
                            property_values[5] += val.ext_sugar ? parseFloat(val.ext_sugar * val.serving) : 0;
                    
                            property_values[6] += val.ext_fat ? parseFloat(val.ext_fat * val.serving) : 0;
                
                            property_values[7] += val.ext_protein ? parseFloat(val.ext_protein * val.serving) : 0;

                           
                        
                    }
                }
            });
      
            if(foods.length == 0){
                notification('info','','Nothing to show');
                return;   
            }
        
            foods.map((val,i)=>{
                $.ajax({
                    url: baseURL + '/api/v1/food_properties',
                    method: 'GET',
                    headers: {
                        'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
                    },
                    success: (data2)=>{
                     
                        data2.data.map((val2,k)=>{
                            if(foods.length > 0 && foods.includes(val2.food_id)){
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

 
        },
        error: (responseJson)=>{
            console.log(responseJson)
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
            let ctr = 0;
            let limit = 0;
            data.data.map((val,i)=>{
            if(val.food_id == null){
                vitamin_a += parseFloat(val.ext_vitamin_a * val.serving);
                vitamin_c += parseFloat(val.ext_vitamin_c * val.serving);
                vitamin_d += parseFloat(val.ext_vitamin_d * val.serving);
                vitamin_e += parseFloat(val.ext_vitamin_e * val.serving);
                protein += parseFloat(val.ext_protein * val.serving);
                salt += parseFloat(val.ext_salt * val.serving);
                sugar += parseFloat(val.ext_sugar * val.serving);
                fat += parseFloat(val.ext_fat * val.serving);
               
            }
          
                if(moment(val.created_at).format("MMM Do YYYY") == moment(new Date()).format("MMM Do YYYY")){
                  
                $.ajax({
                    url: baseURL + '/api/v1/food_properties/food/' + val.food_id,
                    method: 'GET',
                    headers: {
                        'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
                    },
                    success: (data2)=>{
                    
                        data2.data.map((val2)=>{
                            if(val.food_id == val2.food_id){
                            switch(val2.property.toLowerCase().trim()){
                                case 'vitamina':
                                vitamin_a = parseFloat(vitamin_a + val2.amount);
                                break;
                                case 'vitaminc':
                                vitamin_c = parseFloat(vitamin_c + val2.amount);
                                break;
                                case 'vitamind':
                                vitamin_d = parseFloat(vitamin_d + val2.amount);
                                break;
                                case 'vitamine':
                                vitamin_e = parseFloat(vitamin_e + val2.amount);
                                break;
                                case 'salt':
                                salt = parseFloat(salt + val2.amount);
                                break;
                                case 'sugar':
                                sugar = parseFloat(sugar + val2.amount);
                                break;
                                case 'protein':
                                protein = parseFloat(protein + val2.amount);
                                break;

                                case 'fat':
                                fat = parseFloat(fat + val2.amount);
                                break;
                            }

                            limit++;
                        }

                        })
                   
              
                        if(ctr == limit){
                            ctr++;
                           
                         
                            $.ajax({
                                url: baseURL + '/api/v1/daily_limit/user/' + sessionStorage.getItem('user_id'),
                                // url: baseURL + '/api/v1/daily_limit/',
                                method: 'GET',
                                headers: {
                                    'Authorization' : `Bearer ${sessionStorage.getItem('token')}`
                                },
                                success: (data3)=>{
                                    
                                    if(data3.data.length == 0){
                                        data3.data[0] = {
                                            'vitamin_a' : 0,
                                            'vitamin_c' : 0,
                                            'vitamin_d' : 0,
                                            'vitamin_e' : 0,
                                            'salt' : 0,
                                            'protein' : 0,
                                            'sugar' : 0,
                                            'fat' : 0,
                                        };
                                    }
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
                                    String(parseFloat( protein/data3.data[0].protein) * 100) + "%");
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

const loadFromExtAPI = (extAPIURL, extAPIKEY, ctr, baseURL)  =>{
    
    //External API Enpoint for Food List
    //External API -> Food Data Central API -> as of 2022

    let limit = 80;
   
    let  url = extAPIURL + `foods/list?pageSize=${limit}&pageNumber=${ctr}&api_key=` + extAPIKEY; //

    $.ajax({
        url:  baseURL + '/api/v1/daily_limit/user/' + sessionStorage.getItem('user_id'),
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
        },

        success: (data0)=>{
           
       // console.log(data0);
        //
        //AJAX
        $.ajax({
            url: url,
            method: 'GET',
            /*
            beforeSend: function(){
                Swal.fire({
                    text: 'Loading...',
                    showConfirmButton: false,
                    icon: 'info',
                
                });
            },
            */
            success: (data)=>{

                if(data.length > 0){
                    let code = ``;
                    let safe = ``;
                    let unsafe = ``;

                    data.map((val)=>{
                  
              
                        let check = 0;
                    
                        val.foodNutrients.map((val2)=>{
                            if(val2.name.includes('Vitamin A')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].vitamin_a){
                                        check = 1;
                                    }
                                }
                            }else if(val2.name.includes('Vitamin C')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].vitamin_c){
                                        check = 1;
                                    }
                                }
                            }else if(val2.name.includes('Vitamin D')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].vitamin_d){
                                        check = 1;
                                    }
                                }
                            }else if(val2.name.includes('Vitamin E')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].vitamin_e){
                                        check = 1;
                                    }
                                }
                            }else if(val2.name.includes('Sodium')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].salt){
                                        check = 1;
                                    }
                                }
                            }else if(val2.name.includes('Sugar')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].sugar){
                                        check = 1;
                                    }
                                }
                            }else if(val2.name.includes('Lipid')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].fat){
                                        check = 1;
                                    }
                                }
                            }else if(val2.name.includes('Protein')){
                                if(data0.data.length > 0){
                                    if(parseFloat(val2.amount) > data0.data[0].protein){
                                        check = 1;
                                    }
                                }
                            }

                            if(check == 1){
                                //&#xf071
                                unsafe += `<option class = 'external_food text-danger' value = '${JSON.stringify(val)}' data-icon = 'fa-skull-crossbones' >${val.description} </option>`;
                            }else{
                                safe += `<option class = 'external_food' value = '${JSON.stringify(val)}'>${val.description}</option>`;
                            }
                        });
                        

                     
                    }).join("");

                    code = `<optgroup label = 'Safe'>` + safe + `</optgroup><optgroup label = 'Unsafe'>` + unsafe + `</optgroup>`

                    $('#intake_food_id_').append(code);
                    $('#set_food').append(code);
                    

                }
             

                
            }
        })
        //AJAX:end
        //
    }
})
        
   
   
};





