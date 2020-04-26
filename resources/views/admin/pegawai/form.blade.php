{!! Form::model($model, [
    'route' => !empty($model) ? ['pegawai.update', $model['id']] : 'pegawai.store',
    'method' => !empty($model) ? 'PUT' : 'POST'
]) !!}     

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-user"></i>      
                    {{ Form::text('nama',
                    !empty($model) ? $model['nama'] : null, 
                    ['class'=>'form-control',
                    'placeholder'=>'Nama Anda', 
                    'id'=>'nama',
                    'autocomplete'=>'off']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-credit-card"></i> 
                    {{ Form::text('nip',
                    !empty($model) ? $model['nip'] : null,  
                    ['class'=>'form-control', 
                    'maxlength'=>'5',
                    'placeholder'=>'NIP Anda',
                    'id'=>'nip', 
                    'autocomplete'=>'off']) }}
                </div>
            </div>  
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-briefcase"></i>  
                    {{ Form::select('jabatan', ['1'=>'Direktur', 
                                                '2'=>'Manager',
                                                '3'=>'Asisten Manager', 
                                                '4'=>'Supervisor', 
                                                '5'=>'Karyawan',
                                                '6'=>'Oprasional'], 
                                                null,
                    ['class'=>'form-control', 
                    'placeholder'=>'- Jabatan Anda -',
                    'id'=>'jabatan']) }} 
                </div>
            </div>   
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-home"></i>      
                    {{ Form::text('tempat_lahir',
                    !empty($model) ? $model['tempat_lahir'] : null, 
                    ['class'=>'form-control', 
                    'placeholder'=>'Tempat Lahir Anda',
                    'id'=>'tempat_lahir']) }}
                </div>
            </div>  
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-calendar"></i>      
                    {{ Form::text('tanggal_lahir',
                    !empty($model) ? $model['tanggal_lahir'] : null, 
                    ['class'=>'form-control', 
                    'placeholder'=>'Tanggal Lahir Anda', 
                    'id'=>'tanggal_lahir']) }}
                </div>
            </div>   
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-heart"></i>  
                    {{ Form::select('jenis_kelamin', ['L'=>'Laki-Laki', 'P'=>'Perempuan'], null,
                    ['class'=>'form-control', 
                    'placeholder'=>'- Jenis Kelamin Anda -',
                    'id'=>'jenis_kelamin']) }} 
                </div>
            </div>  
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-phone"></i>      
                    {{ Form::text('no_handphone',
                    !empty($model) ? $model['no_handphone'] : null, 
                    ['class'=>'form-control', 
                    'placeholder'=>'No. Handphone Anda',
                    'maxlength'=>'12',
                    'oninput'=>'onlyNumber(this)',
                    'id'=>'no_handphone',
                    'autocomplete'=>'off']) }}
                </div>
            </div>   
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-envelope"></i>      
                    {{ Form::email('email',
                    !empty($model) ? $model['email'] : null,
                    ['class'=>'form-control', 
                    'placeholder'=>'Alamat Email Anda', 
                    'id'=>'email',
                    'autocomplete'=>'off']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-lock"></i>      
                    {{ Form::input('password', 'password',
                    !empty($model) ? $model['password'] : null,
                    ['class'=>'form-control',
                    'placeholder'=>'Password Email Anda', 
                    'id'=>'password',
                    'autocomplete'=>'off']) }}
                </div>
            </div>
        </div>    
        
        <div class="col-sm-3 col-sm-pull-0">
            <div class="form-group">
                {!! Form::checkbox('_password', 
                0,
                false, 
                ['onClick'=>'showPassword()']) !!}

                {!! Form::label('_password', 
                'Lihat Password') !!}
            </div>
        </div> 
    </div>
    
    {{-- <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-camera"></i>      
                    {{ Form::file('photo_id', ['class'=>'form-control']) }} 
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-map-marker"></i>    
                    {{ Form::textarea('alamat', 
                    !empty($model) ? $model['alamat'] : null,
                    ['class'=>'form-control', 
                    'placeholder'=>'Alamat Rumah Anda', 
                    'id'=>'alamat',
                    'rows'=>'2']) }}
                </div>
            </div>
        </div>        
    </div>
    
{!! Form::close() !!}