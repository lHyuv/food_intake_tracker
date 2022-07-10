let global_ctr = 0;
let tr = 'tr';
const showElement = (type, value, mode) =>{
    let selector = "";
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

const appendEl = (el, code) =>{
    $(el).append(code);
}