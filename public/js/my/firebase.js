// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyADvzthdRYlmDzQSOUgXNrR9vmUWPfUzos",
    authDomain: "phpfirebase-29578.firebaseapp.com",
    databaseURL: "https://phpfirebase-29578.firebaseio.com",
    projectId: "phpfirebase-29578",
    storageBucket: "phpfirebase-29578.appspot.com",
    messagingSenderId: "168271572929",
    appId: "1:168271572929:web:134f3182e841d1c91e0940",
    measurementId: "G-4R4Y8F77HK"
  };

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();

var refPegawai = 'pegawai';
var db = firebase.database();
var ref = db.ref(refPegawai);
var lastKey = 0;

function createPegawai(ref, idChild, data) {
    db.ref(ref + '/' + idChild).set(data);
    console.log('tambah data sukses');
}

function checkNip(orderByValue) {
    ref.orderByChild('nip').equalTo(orderByValue).on('value', function(snapshot) {
        if (snapshot.exists()){
            localStorage.setItem('existsNip', JSON.parse(true));
        } 
    });
}

function checkHp(orderByValue) {
    ref.orderByChild('no_handphone').equalTo(orderByValue).on('value', function(snapshot) {
        if (snapshot.exists()){
            localStorage.setItem('existsHp', JSON.parse(true));
        }
    });
}

function checkEmail(orderByValue) {
    ref.orderByChild('email').equalTo(orderByValue).on('value', function(snapshot) {
        if (snapshot.exists()){
            localStorage.setItem('existsEmail', JSON.parse(true));
        }
    });
}

function getLastKey() {
    ref.limitToLast(1).on('child_added', function(snapshot) {
        var key = parseInt(snapshot.key);
        lastKey = key + 1;
        localStorage.setItem('lastKey', lastKey);
    });
    // localStorage.setItem('lastKey', lastKey);
}

function removeLocalStorage() {
    localStorage.removeItem('lastKey');
    localStorage.removeItem('existsNip');
    localStorage.removeItem('existsHp');
    localStorage.removeItem('existsEmail');
    localStorage.removeItem('dateTime');    
}

function getDateTime() {
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + ' ' + time;
    localStorage.setItem('dateTime', dateTime);
}

$('#sss').click(function (event) {
    event.preventDefault();
    var ref = 'pegawai';
    var isCheckNip = false;
    var isCheckHp = false;
    var isCheckEmail = false;
    var idChild;

    var form = $('#modal-body form'),
        url = form.attr('route'),
        method = form.attr('method');
    
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    // var nama_pegawai = document.getElementById('nama').value;
    var nip_pegawai = document.getElementById('nip').value;
    // var jabatan_pegawai = document.getElementById('jabatan').value;
    // var tempat_lahir_pegawai = document.getElementById('tempat_lahir').value;
    // var tanggal_lahir_pegawai = document.getElementById('tanggal_lahir').value;
    // var jenis_kelamin_pegawai = document.getElementById('jenis_kelamin').value;
    var no_handphone_pegawai = document.getElementById('no_handphone').value;
    var email_pegawai = document.getElementById('email').value;
    // var password_pegawai = document.getElementById('password').value;
    // var alamat_pegawai = document.getElementById('alamat').value;


    $.ajax({
        url : url,
        method: method,
        data : form.serialize(),
        beforeSend: function() { 
            getLastKey();
            // checkNip(nip_pegawai);
            // checkHp(no_handphone_pegawai);
            // checkEmail(email_pegawai);
            // isCheckNip = localStorage.getItem('existsNip');
            // isCheckHp = localStorage.getItem('existsHp');
            // isCheckEmail = localStorage.getItem('existsEmail');
            // idChild = localStorage.getItem('lastKey');            
        },
        complete: function() { 
            // removeLocalStorage();
        },
        success: function (response) {
            checkNip(nip_pegawai);
            checkHp(no_handphone_pegawai);
            checkEmail(email_pegawai);
            isCheckNip = localStorage.getItem('existsNip');
            isCheckHp = localStorage.getItem('existsHp');
            isCheckEmail = localStorage.getItem('existsEmail');
            idChild = localStorage.getItem('lastKey'); 
            
            
            if (isCheckNip === false && isCheckEmail === false && isCheckHp === false) {
                getDateTime();
                // var waktu_buat_pegawai = localStorage.getItem('dateTime');
                // var dataPegawai = {
                //     nama: nama_pegawai,
                //     nip: nip_pegawai,
                //     jabatan: jabatan_pegawai,
                //     tempat_lahir: tempat_lahir_pegawai,
                //     tanggal_lahir: tanggal_lahir_pegawai,
                //     jenis_kelamin: jenis_kelamin_pegawai,
                //     no_handphone: no_handphone_pegawai,
                //     email: email_pegawai,
                //     password: password_pegawai,
                //     alamat: alamat_pegawai,
                //     waktu_buat: waktu_buat_pegawai
                // };
                // createPegawai(ref, idChild, dataPegawai);
                // form.trigger('reset');
                // $('#modal').modal('hide');
                // $('#datatable').DataTable().ajax.reload();

                swal({
                    type : 'success',
                    title : 'Success!',
                    text : 'Data has been saved!'
                });
            } else {                
                var err = {};

                if (isCheckNip) {
                    err.nip = 'NIP sudah ada';
                }

                if (isCheckHp) {
                    err.no_handphone = 'No Handphone sudah ada';
                }

                if (isCheckEmail) {
                    err.email = 'Email sudah ada';
                }

                $.each(err, function (prop, value) {
                    $('#' + prop)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block" id="error-form"><strong>' + value + '</strong></span>');
                });
            }

            removeLocalStorage();
        },
        error: function (xhr) {
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