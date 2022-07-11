let global_ctr = 0;
let tr = 'tr';
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
        },
        error: ({responseJson})=>{
            console.log(responseJson);
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
    alert("Submitted!");

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

            console.log(property);
            console.log(property_values);
        }

    });
 
};