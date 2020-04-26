{!! Form::model($model, [
    'route' => !empty($model) ? ['lokasi.update', $model['id']] : 'lokasi.store',
    'method' => !empty($model) ? 'PUT' : 'POST'
]) !!}     

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-pencil"></i>      
                    {{ Form::text('nama',
                    !empty($model) ? $model['nama'] : null, 
                    ['class'=>'form-control',
                    'placeholder'=>'Nama Lokasi', 
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
                    <i class="glyphicon glyphicon-pencil"></i> 
                    {{ Form::number('lat',
                    !empty($model) ? $model['lat'] : null,  
                    ['class'=>'form-control', 
                    'placeholder'=>'Latitude Lokasi',
                    // 'oninput'=>'onlyNumberDecimal(this)',
                    'id'=>'lat', 
                    'autocomplete'=>'off']) }}
                </div>
            </div>  
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-pencil"></i> 
                    {{ Form::number('long',
                    !empty($model) ? $model['long'] : null,  
                    ['class'=>'form-control', 
                    'placeholder'=>'Longtitude Lokasi',
                    // 'oninput'=>'onlyNumberDecimal(this)',
                    'id'=>'long', 
                    'autocomplete'=>'off']) }}
                </div>
            </div>   
        </div>
    </div>

    @if(!empty($model))
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="inner-addon left-addon">
                    {!! Form::checkbox('is_aktif',
                    1, 
                    !empty($model['kode_status'])? $model['kode_status'] === '1'? true : false : false ) !!}

                    {!! Form::label('is_aktif', 
                    ' Aktif') !!}
                </div>
            </div>
        </div>
    </div>
    @endif

{!! Form::close() !!}