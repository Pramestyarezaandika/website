@extends('adminlte::page')

@section('title', 'Pegawai')

@section('content_header')
    <h1>Pegawai</h1>
@stop

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Datatable Pegawai <a href="{{ route('pegawai.create') }}" class="btn btn-success pull-right modal-show" style="margin-top: -8px;" title="Tambah Pegawai">
            <i class="icon-plus"></i>Tambah Pegawai</a>
        </h3>
    </div>
    <div class="panel-body">
        <table id="datatable" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="datatable-nosort">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th id="th">ID</th>
                    <th id="th" class="datatable-nosort" style="width:10%"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                </tr>
                {{-- <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th id="th">ID</th>
                    <th id="th"></th>
                </tr> --}}
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>    
    var isData = {!! json_encode($isDataPegawai) !!};
    var num = {!! json_encode($num) !!};
    console.log(num);
    // console.log(isData);    
    if (isData) {
        // console.log('ada data');
        $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            order: [5, 'desc'],
            columnDefs: [{
                targets: 'datatable-nosort',
                orderable: false}
            ],
            ajax: "{{ route('table.pegawai') }}",
            columns: [
                {data: 'DT_RowIndex', searchable: false},
                {data: 'nip', name: 'nip'},
                {data: 'nama', name: 'name'},
                {data: 'jabatan', name: 'jabatan',
                render: function(data) {
                    if (data === '1') {
                        return 'Direktur'
                    } else if (data === '2') {
                        return 'Manager'
                    } else if (data === '3') {
                        return 'Asisten Manager'
                    } else if (data === '4') {
                        return 'Supervisor'
                    } else if (data === '5') {
                        return 'Karyawan'
                    } else if (data === '6') {
                        return 'Oprasional'
                    } else {
                        return '-'
                    }
                }},  
                {data: 'email', name: 'email'},
                {data: 'id', name: 'id', searchable: false, visible: false},
                {data: 'action', searchable: false}
            ]
        });
    } else {
        // console.log('enggak ada data');
        var id = document.getElementById('th');
        var att = document.createAttribute('hidden'); 
        id.setAttributeNode(att);   
        $('#datatable').DataTable({
            responsive: true,
            processing: true,
            scrollX: true,
            order: [5, 'desc'],
            columnDefs: [{
                targets: 'datatable-nosort',
                orderable: false}
            ]
        });
    }
</script>
@stop