<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-11">
                <img class="user-profile-img" src="{{ asset($model['icon_profile']) }}" alt="User Profile">
                <h3 class="profile-username text-center"><b>{{ $model['nama'] }}</b></h3>
                <p class="text-muted text-center"><b>{{ $model['jabatan'] }} | {{ $model['nip'] }}</b></p>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-birthday-cake margin-r-5"></i> Tempat, Tanggal Lahir</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <p class="text-muted">{{ $model['tempat_lahir'] }}, {{ $model['tanggal_lahir'] }}</p>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-heart margin-r-5"></i> Kelamin</strong>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <p class="text-muted">{{ $model['jenis_kelamin'] }}</p>           
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-phone margin-r-5"></i> No Handphone</strong>           
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <p class="text-muted">{{ $model['no_handphone'] }}</p> 
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>         
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <p class="text-muted">{{ $model['email'] }}</p>        
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="row">
                    <div class="col-sm-6">
                        <strong><i class="fa fa-lock margin-r-5"></i> Password</strong>
                    </div>
                    <div class="col-sm-6">
                        <input type="checkbox" onclick="showPasswordShow()" id="showPassword"> Lihat Password
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <p class="text-muted" id="password">{{ $model['password'] }}</p>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <p class="text-muted">{{ $model['alamat'] }}</p>
                    </div>
                </div>
            </div>
        </div>       

    </div>
</div>