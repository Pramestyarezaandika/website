@extends('adminlte::page')

@section('title', 'Lokasi')

@section('content_header')
    <h1>Lokasi</h1>
@stop

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Datatable Lokasi <a href="{{ route('lokasi.create') }}" class="btn btn-success pull-right modal-show" style="margin-top: -8px;" title="Tambah Lokasi">
            <i class="icon-plus"></i> Tambah Lokasi</a>
        </h3>
    </div>
    <div class="panel-body">
        <table id="datatable" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="datatable-nosort">No</th>
                    <th>Nama Lokasi</th>
                    <th>Latitude Lokasi</th>
                    <th>Longtitude Lokasi</th>
                    <th>Status</th>
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
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>    
    var isData = {!! json_encode($isDataLokasi) !!};
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
            ajax: "{{ route('table.lokasi') }}",
            columns: [
                {data: 'DT_RowIndex', searchable: false},
                {data: 'nama', name: 'nama'},
                {data: 'lat', name: 'lat'},
                {data: 'long', name: 'long'},
                {data: 'kode_status', name: 'kode_status',
                render: function(data) {
                    if (data === '1') {
                        var label = '<a href="" class="btn btn-success disabled" style="margin-top: -8px;"> Aktif </a>'
                        return label
                    } else if (data === '0') {
                        var label = '<a href="" class="btn btn-danger disabled" style="margin-top: -8px;"> Non-Aktif </a>'
                        return label
                    } else {
                        return '-'
                    }
                }},  
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
            order: [1, 'desc'],
            columnDefs: [{
                targets: 'datatable-nosort',
                orderable: false}
            ]
        });
    }
</script>
@stop