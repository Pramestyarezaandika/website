// function validateEmail(email) {
//     var format = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return format.test(email);
// }

function validateEmail(email) {
    var atPos = email.indexOf("@");  
    var dotPos = email.lastIndexOf(".");  
    if (atPos < 1 || dotPos < atPos + 2 || dotPos + 1 >= email.length) {
        return false;  
    } else {
        return true;
    }
}

$('#btn-login').click(function (event) {
    event.preventDefault();
    console.log('click button login!!!');

    var form = $('#login-box-body form'),
        url = form.attr('action'),
        method = form.attr('method');
    
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    
    console.log('ajax!!!');
    $.ajax({
        url : url,
        method: method,
        data : form.serialize(),
        beforeSend: function() { 
            console.log('beforeSend!!!');

            var emailFormat = validateEmail(email);
            console.log('format email is : ' + emailFormat);
            if (email !== '' && emailFormat && password !== '' && password.length >= 8) {
                Swal.fire({
                    title: 'Loading',
                    text: 'Please wait...',
                    imageUrl: 'img/loading.gif',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    imageAlt: 'loading',
                });
            }
        },
        complete: function() { 
            console.log('complete!!!');
        },
        success: function (response) {
            console.log('success!!!');

            var res = response.msg;
            if (res == 'login') {
                console.log(res);
                window.location = 'dashboard';
            } else {
                console.log(res);
    
                Swal.close();

                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');

                var key = response.key;
                var value = response.value;
                $('#' + key)
                    .closest('.form-group')
                    .addClass('has-error')
                    .append('<span class="help-block"><strong>' + value + '</strong></span>');
            }
        },
        error: function (xhr) {
            console.log('error!!!');
            var res = xhr.responseJSON;            
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block"><strong>' + value + '</strong></span>');
                });
            } 
        }
    })

});
  