<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-11">
                <img class="location-img" src="{{ asset($model['img_lokasi']) }}" alt="Img Location">
                <h3 class="profile-username text-center"><b>{{ $model['nama'] }}</b></h3>
                <p style="text-align:center;">
                    @if($model['kode_status'] === '1') 
                        <a href="" class="btn btn-success disabled"> Aktif </a>
                    @else
                        <a href="" class="btn btn-danger disabled"> Non-Aktif </a>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6">

        <div class="row">

            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Lokasi</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Latitude</strong>
                        <br>
                        <p class="text-muted">{{ $model['lat'] }}</p>
                    </div>
                    <div class="col-sm-6">
                        <strong>Longtitude</strong>
                        <br>
                        <p class="text-muted">{{ $model['long'] }}</p>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-check-circle margin-r-5"></i> Status</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <p class="text-muted">
                            @if($model['kode_status'] === '1') 
                                Aktif
                            @else
                                Non-Aktif
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-clock-o margin-r-5"></i> Waktu</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Waktu Buat</strong>
                        <br>
                        <p class="text-muted">{{ $model['waktu_buat'] }}</p>
                    </div>
                    <div class="col-sm-6">
                        <strong>Waktu Perbarui</strong>
                        <br>
                        <p class="text-muted">{{ $model['waktu_perbarui'] }}</p>
                    </div>
                </div>
            </div>

        </div>       
    </div>
</div>