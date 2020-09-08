window.handle_response = function(vue_object ,response , show_message , show_swal , hide_form = true ) {

    let message = response.message;

    if(response.status) {
        if(show_message) {
            vue_object.msg.success = message;
            vue_object.msg.error = "";
            scrollToDiv("#kt_body");
        }
        if(show_swal) {
            Swal.fire("تم", message, "success");
        }

        if(hide_form) {
            setTimeout(function () {
                $('.show-form').addClass('hidden');
            } , 1500);
        }

    }else {
        if(show_message) {
            vue_object.msg.success = "";
            vue_object.msg.error = message;
            scrollToDiv("#kt_body");
        }
        if(show_swal) {
            Swal.fire("خطأ", message, "error");
        }
    }

    setTimeout(function () {
        vue_object.msg.success = '';
    } , 1500);


    return response;
}
window.clear_message = function(vue_object) {
    vue_object.msg.success = '';
    vue_object.msg.error = '';
}


window.pluck_ = key => array => Array.from(new Set(array.map(obj => obj[key])));

window.sort_number= function(a, b) {
    return a - b;
}

window.read_url = function(input, selector) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $(selector).attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
}



window.makeid = function(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

window.scrollToDiv = function(selector) {
    $("html, body").animate({
        scrollTop: $(selector).offset().top
    }, 700);
}


// multi language
window.getMultiLangField = function(default_value = '') {
    let fields = {};
    locales.forEach(function (value) {
        fields[value] = default_value;
    });
    return fields;
}
