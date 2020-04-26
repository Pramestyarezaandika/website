<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Database;
use Validator,Redirect,Response;
use DataTables;;

class LokasiController extends Controller
{
    public function __construct(Database $database)
    {
        $this->refLokasi = 'lokasi';
        $this->database = $database;
    }

    public function getLastkey()
    {
        $key = 0;
        try {
            $db = $this->database->getReference($this->refLokasi);
            $snapshot = $db->getSnapshot();

            if ($snapshot->exists()) {
                $keys = $db->getChildKeys();
                $lastKey = intval(max($keys));
                $key = $lastKey + 1;
                return $key;
            } 
            return $key;
        } catch (\Throwable $th) {
            return $key;
        }
        
    }

    public function checkExists($ref, $key, $val)
    {
        try {
            foreach ($ref as $item) {
                if (isset($item[$key]) && $item[$key] === $val) {
                    return true;
                }
            }
            return false;
        } catch (\Throwable $th) {
            return false;
        }        
    }

    public function index()
    {
        try {
            $db = $this->database->getReference($this->refLokasi);
            $refExists = $db->getSnapshot()->exists(); 
            $num = $db->getSnapshot()->numChildren();
            $isDataLokasi = $refExists;           
        } catch (\Throwable $th) {
            $isDataLokasi = false;
            $num = 0;
        }
        return view('admin.lokasi.index', compact('isDataLokasi', 'num'));
    }

    public function create()
    {
        $model = [];

        return view('admin.lokasi.form', compact('model'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ],[
            'nama.required' => 'Nama Lokasi harus di isi',
            'nama.max' => 'Nama Lokasi harus maksimal 100 karater',
            'lat.required' => 'Latitude Lokasi harus di isi',
            'lat.numeric' => 'Latitude Lokasi harus angka',
            'long.required' => 'Longtitude Lokasi harus di isi',
            'long.numeric' => 'Longtitude Lokasi harus angka',
        ]);

        $validator->validate();

        $db = $this->database->getReference($this->refLokasi);
        $value = $db->getValue();

        $keyLat = 'lat';     
        $keyLong = 'long';   

        $childKey = $this->getLastkey();

        $namaLokasi = $request->nama;
        $latLokasi = $request->lat;
        $longLokasi = $request->long;
        $codeStatus = '1';
        $waktuBuat = date('d-m-Y H:i:s'); 

        $isLat = $this->checkExists($value, $keyLat, $latLokasi);
        $isLong = $this->checkExists($value, $keyLong, $longLokasi);

        $data = [
            'id' => $childKey,
            'nama' => $namaLokasi,
            'lat' => $latLokasi,
            'long' => $longLokasi,
            'kode_status' => $codeStatus,
            'waktu_buat' => $waktuBuat,
            'waktu_perbarui' => $waktuBuat,
        ];

        if ($isLat && $isLong) {
            $info['code'] = false;
            $info['msg'] = 'Tambah Data Lokasi: GAGAL';
            $err = [];

            if ($isLat) {
                $err['lat'] = 'Lokasi Latitude sudah digunakan';
            }

            if ($isLong) {
                $err['long'] = 'Lokasi Longtitude sudah digunakan';
            }

            $info['err'] = $err;

            return response()->json($info);
        } else {
            $db->getChild($childKey)->set($data);
            $info['code'] = true;
            $info['msg'] = 'Tambah Data Lokasi: SUKSES';
            return response()->json($info);
        }   
    }

    public function show($id)
    {
        $db = $this->database->getReference($this->refLokasi);
        $valueId = $db->getChild($id)->getValue();
        $imgLokasi = 'img/univ-1.jpg';
        $valueId['img_lokasi'] = $imgLokasi;

        $model = $valueId;

        return view('admin.lokasi.show', compact('model'));
    }

    public function edit($id)
    {
        $db = $this->database->getReference($this->refLokasi);
        $valueId = $db->getChild($id)->getValue();
        $model = $valueId;

        return view('admin.lokasi.form', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ],[
            'nama.required' => 'Nama Lokasi harus di isi',
            'nama.max' => 'Nama Lokasi harus maksimal 100 karater',
            'lat.required' => 'Latitude Lokasi harus di isi',
            'lat.numeric' => 'Latitude Lokasi harus angka',
            'long.required' => 'Longtitude Lokasi harus di isi',
            'long.numeric' => 'Longtitude Lokasi harus angka',
        ]);

        $validator->validate();

        $db = $this->database->getReference($this->refLokasi);
        $value = $db->getValue();
        $valueId = $db->getChild($id)->getValue();

        $keyLat = 'lat';     
        $keyLong = 'long'; 
        
        $latId = $valueId[$keyLat];
        $longId = $valueId[$keyLong];

        $isAktif = $request->is_aktif;
        if (isset($isAktif)) {
            $codeStatus = '1';
        } else {
            $codeStatus = '0';
        }

        $childKey = $id;
        $namaLokasi = $request->nama;
        $latLokasi = $request->lat;
        $longLokasi = $request->long;
        $waktuBuat = $valueId['waktu_buat']; 
        $waktuPerbarui = date('d-m-Y H:i:s'); 

        if ($latId !== $latLokasi) {
            $isLat = $this->checkExists($value, $keyLat, $latLokasi);  
        } else {
            $isLat = false;
        }

        if ($longId !== $longLokasi) {
            $isLong = $this->checkExists($value, $keyLong, $longLokasi);    
        } else {
            $isLong = false;
        }


        $data = [
            'id' => $childKey,
            'nama' => $namaLokasi,
            'lat' => $latLokasi,
            'long' => $longLokasi,
            'kode_status' => $codeStatus,
            'waktu_buat' => $waktuBuat,
            'waktu_perbarui' => $waktuPerbarui,
        ];

        if ($isLat && $isLong) {
            $info['code'] = false;
            $info['msg'] = 'Perbarui Data Lokasi: GAGAL';
            $err = [];

            if ($isLat) {
                $err['lat'] = 'Lokasi Latitude sudah digunakan';
            }

            if ($isLong) {
                $err['long'] = 'Lokasi Longtitude sudah digunakan';
            }

            $info['err'] = $err;

            return response()->json($info);
        } else {
            $db->getChild($childKey)->set($data);
            $info['code'] = true;
            $info['msg'] = 'Perbarui Data Lokasi: SUKSES';
            return response()->json($info);
        }   
    }

    public function destroy($id)
    {
        $db = $this->database->getReference($this->refLokasi);
        $db->getChild($id)->remove();
    }

    public function dataTable()
    {
        $db = $this->database->getReference($this->refLokasi);
        $value = $db->getValue();
        $modelLokasi = array_values(array_filter($value));

        $model = $modelLokasi;

        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                return view('layouts._action', [
                    'model' => $model,
                    'url_show' => route('lokasi.show', $model['id']),
                    'url_edit' => route('lokasi.edit', $model['id']),
                    'url_destroy' => route('lokasi.destroy', $model['id'])
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);      
    }
}
