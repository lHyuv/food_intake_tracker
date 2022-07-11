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