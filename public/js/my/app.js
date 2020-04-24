function onlyNumber(input) {
    let value = input.value;
    let numbers = value.replace(/[^0-9]/g, "");
    input.value = numbers;
}

function showPassword() {
    var x = document.getElementById('password');
    if (x.type === 'password') {
        x.type = 'text';
    } else {
        x.type = 'password';
    }
}

function showPasswordShow() {
    var cbxShowPassword = document.getElementById('showPassword');
    if (cbxShowPassword.checked === true){
        document.getElementById('password').innerHTML = valPassword;
    } else {
        changePasswordToSymbol();
    }
}

function changePasswordToSymbol() {
    var pPassword = document.getElementById('password').innerHTML;
    valPassword = pPassword;
    var valLength = pPassword.length;
    var strPassword = '\u2022'.repeat(valLength);
    document.getElementById('password').innerHTML = strPassword;
}

$('body').on('click', '.modal-show', function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');

    $('#modal-title').text(title);
    $('#modal-btn-save').removeClass('hide')
    .text(me.hasClass('edit') ? 'Update' : 'Create');

    $.ajax({
        url: url,
        dataType: 'html',
        beforeSend: function() {
            // var url = 'https://gifimage.net/wp-content/uploads/2017/09/ajax-loading-gif-transparent-background-2.gif';
            // var loading = "<img src='" + url + "' alt='Loading...' height='70' width='70' class='loading-form'>";
            if (me.hasClass('edit')) {
                var loading = '<p align="center"><b>Mohon Tunggu...</b></p>';
                $('#modal-body').html(loading);
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
        success: function (response) {
            Swal.close();
            $('#modal-body').html(response);

            $('#tanggal_lahir').datepicker({
                endDate: 'today',
                todayHighlight: true,
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        }
    });

    $('#modal').modal('show');
});

$('#modal-btn-save').click(function (event) {
    event.preventDefault();

    // var form = $('#modal-body form'),
    //     url = form.attr('route'),
    //     method = form.attr('method');
    var form = $('#modal-body form'),
        url = form.attr('action'),
        method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
    
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url : url,
        method: method,
        data : form.serialize(),
        beforeSend: function() {
            Swal.fire({
                title: 'Loading',
                text: 'Please wait...',
                imageUrl: 'img/loading.gif',
                showConfirmButton: false,
                allowOutsideClick: false,
                imageAlt: 'loading',
            });           
        },
        complete: function() { 
        },
        success: function (response) {
            var resCode = response.code;
            var resMessage = response.msg;
            if (!resCode) {
                Swal.close();
                var errors = response.err;
                $.each(errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block" id="error-form"><strong>' + value + '</strong></span>');
                });
            } else {
                if (num !== 0) {
                    form.trigger('reset');
                    $('#modal').modal('hide');
                    $('#datatable').DataTable().ajax.reload();                
                } else {
                    console.log('enggak ada');
                    form.trigger('reset');
                    $('#modal').modal('hide');
                    location.reload();
                }

                Swal.fire({
                    type : 'success',
                    title : 'SUKSES',
                    text : resMessage
                });
            }
        },
        error: function (xhr) {
            Swal.close();
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block" id="error-form"><strong>' + value + '</strong></span>');
                });
            } 
        }
    })
});


$('body').on('click', '.btn-delete', function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        title: 'Are you sure want to delete ' + title + ' ?',
        text: 'You won\'t be able to revert this!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': csrf_token
                },
                success: function (response) {
                    if (num !== 1) {
                        $('#datatable').DataTable().ajax.reload(); 
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'Data has been deleted!'
                        });               
                    } else {
                        location.reload();
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'Data has been deleted!'
                        });
                    }                    
                },
                error: function (xhr) {
                    var res = xhr.responseJSON;
                    console.log(res);
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });
});

$('body').on('click', '.btn-show', function (event) {
    event.preventDefault();

    var loading = '<p align="center"><b>Mohon Tunggu...</b></p>';
    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');

    // $('#modal-title').text(title);
    $('#modal-title').text('Detail');
    $('#modal-btn-save').addClass('hide');
    $('#modal-body').html(loading); 

    $.ajax({
        url: url,
        dataType: 'html',
        beforeSend: function() {
            Swal.fire({
                title: 'Loading',
                text: 'Please wait...',
                imageUrl: 'img/loading.gif',
                showConfirmButton: false,
                allowOutsideClick: false,
                imageAlt: 'loading',
            });                                
        },
        success: function (response) {
            Swal.close();
            $('#modal-body').html(response);
            changePasswordToSymbol();
        }
    });

    $('#modal').modal('show');
});

