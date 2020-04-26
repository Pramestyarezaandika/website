<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Database;
use Kreait\Firebase\Auth;
use Kreait\Auth\Request\CreateUser;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Validator,Redirect,Response;
use DataTables;;

class PegawaiController extends Controller
{
    public function __construct(Database $database, Auth $auth)
    {
        $this->refPegawai = 'pegawai';
        $this->database = $database;
        $this->auth = $auth;
        // $this->dbPegawai = $this->database->getReference($refPegawai);
        // $this->snapPegawai = $this->dbPegawai->getSnapshot();
        // $this->valPegawai = $this->snapPegawai->getValue();
    }

    public function index()
    {
        try {
            $db = $this->database->getReference($this->refPegawai);
            $refExists = $db->getSnapshot()->exists(); 
            $num = $db->getSnapshot()->numChildren();
            $isDataPegawai = $refExists;           
        } catch (\Throwable $th) {
            $isDataPegawai = false;
            $num = 0;
        }
        return view('admin.pegawai.index', compact('isDataPegawai', 'num'));
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

    public function getLastkey()
    {
        // $db = $this->dbPegawai;
        // $snapshot = $this->snapPegawai;
        $key = 0;
        try {
            $db = $this->database->getReference($this->refPegawai);
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

    public function create()
    {
        $model = [];

        return view('admin.pegawai.form', compact('model'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|min:5',
            'nama' => 'required|max:250',
            'jabatan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'no_handphone' => 'required|numeric|min:10',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'alamat' => 'required',
        ],[
            'nip.min' => 'NIP harus 5 karakter',
            'nip.required' => 'NIP harus di isi',
            'nama.required' => 'Nama harus di isi',
            'jabatan.required' => 'Jabatan harus di isi',
            'tempat_lahir.required' => 'Tempat Lahir harus di isi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus di isi',
            'tanggal_lahir.date' => 'Tanggal Lahir tidak sesuai format',
            'jenis_kelamin.required' => 'Jenis Kelamin harus di isi',
            'no_handphone.required' => 'No. Handphone harus di isi',
            'no_handphone.numeric' => 'No. Handphone harus angka',
            'no_handphone.min' => 'No. Handphone minimal 10 digit',
            'email.required' => 'E-Mail harus di isi',
            'email.email' => 'E-Mail tidak sesuai format',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 8 karakter',
            'alamat.required' => 'Alamat harus di isi',
        ]);

        $validator->validate();

        $auth = $this->auth;
        $db = $this->database->getReference($this->refPegawai);
        $value = $db->getValue();

        $keyNip = 'nip';     
        $keyHp = 'no_handphone';     
        $keyEmail = 'email'; 
        $childKey = $this->getLastkey();

        $nip = $request->nip;
        $nama = $request->nama;
        $jabatan = $request->jabatan;
        $tempatLahir = $request->tempat_lahir;
        $tanggalLahir = $request->tanggal_lahir;
        $jenisKelamin = $request->jenis_kelamin;
        $noHandphone = $request->no_handphone;
        $email = $request->email;
        $password = $request->password;
        $alamat = $request->alamat;
        $waktuBuat = date('d-m-Y H:i:s'); 

        $isNip = $this->checkExists($value, $keyNip, $nip);
        $isHp = $this->checkExists($value, $keyHp, $noHandphone);
        $isEmail = $this->checkExists($value, $keyEmail, $email);

        $data = [
            'id' => $childKey,
            'nip' => $nip,
            'nama' => $nama,
            'jabatan' => $jabatan,
            'tempat_lahir' => $tempatLahir,
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $jenisKelamin,
            'no_handphone' => $noHandphone,
            'email' => $email,
            'password' => $password,
            'alamat' => $alamat,
            'waktu_buat' => $waktuBuat,
        ];

        $dataEmailPassword = [
            'email' => $email,
            'password' => $password,
        ];

        if (!$isNip && !$isHp && !$isEmail) {
            $db->getChild($childKey)->set($data);
            $auth->createUser($dataEmailPassword);
            $info['code'] = true;
            $info['msg'] = 'Tambah Data Pegawai: SUKSES';
            return response()->json($info);
        } else {
            $info['code'] = false;
            $info['msg'] = 'Tambah Data Pegawai: GAGAL';
            $err = [];

            if ($isNip) {
                $err['nip'] = 'NIP sudah digunakan';
            }

            if ($isHp) {
                $err['no_handphone'] = 'No. Handphone sudah digunakan';
            }

            if ($isEmail) {
                $err['email'] = 'Email sudah digunakan';
            }

            $info['err'] = $err;

            return response()->json($info);
        }   
    }

    public function show($id)
    {
        $db = $this->database->getReference($this->refPegawai);
        $valueId = $db->getChild($id)->getValue();
        $iconProfile = 'img/user-profile.jpg';
        $keyJabatan = $valueId['jabatan'];
        $keyKelamin = $valueId['jenis_kelamin'];
        if ($keyJabatan === '1') {
            $valJabatan = 'Direktur';
        } else if ($keyJabatan === '2') {
            $valJabatan = 'Manager';
        } else if ($keyJabatan === '3') {
            $valJabatan = 'Asisten Manager';
        } else if ($keyJabatan === '4') {
            $valJabatan = 'Supervisor';
        } else if ($keyJabatan === '5') {
            $valJabatan = 'Karyawan';
        } else if ($keyJabatan === '6') {
            $valJabatan = 'Oprasional';
        } else {
            $valJabatan = '-';
        }

        if ($keyKelamin === 'L') {
            $valKelamin = 'Laki - Laki';
            $iconProfile = 'img/male-profile.png';
        } else if ($keyKelamin === 'P') {
            $valKelamin = 'Perempuan';
            $iconProfile = 'img/female-profile.png';
        } else {
            $valKelamin = '-';
        }

        $valueId['jabatan'] = $valJabatan;
        $valueId['jenis_kelamin'] = $valKelamin;
        $valueId['icon_profile'] = $iconProfile;

        $model = $valueId;

        return view('admin.pegawai.show', compact('model'));
    }

    public function edit($id)
    {
        $db = $this->database->getReference($this->refPegawai);
        $valueId = $db->getChild($id)->getValue();
        $model = $valueId;

        // var_dump($model);

        return view('admin.pegawai.form', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|min:5',
            'nama' => 'required|max:250',
            'jabatan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'no_handphone' => 'required|numeric|min:10',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'alamat' => 'required',
        ],[
            'nip.min' => 'NIP harus 5 karakter',
            'nip.required' => 'NIP harus di isi',
            'nama.required' => 'Nama harus di isi',
            'jabatan.required' => 'Jabatan harus di isi',
            'tempat_lahir.required' => 'Tempat Lahir harus di isi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus di isi',
            'tanggal_lahir.date' => 'Tanggal Lahir tidak sesuai format',
            'jenis_kelamin.required' => 'Jenis Kelamin harus di isi',
            'no_handphone.required' => 'No. Handphone harus di isi',
            'no_handphone.numeric' => 'No. Handphone harus angka',
            'no_handphone.min' => 'No. Handphone minimal 10 digit',
            'email.required' => 'E-Mail harus di isi',
            'email.email' => 'E-Mail tidak sesuai format',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 8 karakter',
            'alamat.required' => 'Alamat harus di isi',
        ]);

        $validator->validate();

        $auth = $this->auth;
        $db = $this->database->getReference($this->refPegawai);
        $value = $db->getValue();
        $valueId = $db->getChild($id)->getValue();

        $keyNip = 'nip';     
        $keyHp = 'no_handphone';     
        $keyEmail = 'email'; 
        $keyPassword = 'password'; 
        
        $childKey = $id;
        $nipId = $valueId[$keyNip];
        $noHandphoneId = $valueId[$keyHp];
        $emailId = $valueId[$keyEmail];
        $passwordId = $valueId[$keyPassword];

        $userAuth = $auth->getUserByEmail($emailId);
        $uidUser = $userAuth->uid;

        $nip = $request->nip;
        $nama = $request->nama;
        $jabatan = $request->jabatan;
        $tempatLahir = $request->tempat_lahir;
        $tanggalLahir = $request->tanggal_lahir;
        $jenisKelamin = $request->jenis_kelamin;
        $noHandphone = $request->no_handphone;
        $email = $request->email;
        $password = $request->password;
        $alamat = $request->alamat;
        $waktuBuat = $valueId['waktu_buat']; 
        $waktuPerbarui = date('d-m-Y H:i:s'); 

        if ($nipId !== $nip) {
            $isNip = $this->checkExists($value, $keyNip, $nip);
        } else {
            $isNip = false;
        }

        if ($noHandphoneId !== $noHandphone) {
            $isHp = $this->checkExists($value, $keyHp, $noHandphone);
        } else {
            $isHp = false;
        }

        if ($emailId !== $email) {
            $isEmail = $this->checkExists($value, $keyEmail, $email);
        } else {
            $isEmail = false;
        }

        if ($passwordId !== $password) {
            $isPassword = true;
        } else {
            $isPassword = false;
        }

        $data = [
            'id' => $childKey,
            'nip' => $nip,
            'nama' => $nama,
            'jabatan' => $jabatan,
            'tempat_lahir' => $tempatLahir,
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $jenisKelamin,
            'no_handphone' => $noHandphone,
            'email' => $email,
            'password' => $password,
            'alamat' => $alamat,
            'waktu_buat' => $waktuBuat,
            'waktu_perbarui' => $waktuPerbarui,
        ];

        if (!$isNip && !$isHp && !$isEmail) {
            $db->getChild($childKey)->set($data);
            if ($isEmail) {
                $auth->changeUserEmail($uidUser, $email);
            }

            if ($isPassword) {
                $auth->changeUserPassword($uidUser, $password);
            }

            $info['code'] = true;
            $info['msg'] = 'Perbarui Data Pegawai: SUKSES';
            return response()->json($info);
        } else {
            $info['code'] = false;
            $info['msg'] = 'Perbarui Data Pegawai: GAGAL';
            $err = [];

            if ($isNip) {
                $err['nip'] = 'NIP sudah digunakan';
            }

            if ($isHp) {
                $err['no_handphone'] = 'No. Handphone sudah digunakan';
            }

            if ($isEmail) {
                $err['email'] = 'Email sudah digunakan';
            }

            $info['err'] = $err;

            return response()->json($info);
        }
    }

    public function destroy($id)
    {  
        $auth = $this->auth;
        $db = $this->database->getReference($this->refPegawai);
        $valueId = $db->getChild($id)->getValue();

        $keyEmail = 'email';
        $emailId = $valueId[$keyEmail];
        $user = $auth->getUserByEmail($emailId);
        $userUid = $user->uid;

        $auth->deleteUser($userUid);
        $db->getChild($id)->remove();
    }

    public function dataTable()
    {
        $db = $this->database->getReference($this->refPegawai);
        $value = $db->getValue();
        $modelPegawai = array_values(array_filter($value));

        $model = $modelPegawai;
        // return Datatables::of($valPegawai)->make(true);

        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                return view('layouts._action', [
                    'model' => $model,
                    'url_show' => route('pegawai.show', $model['id']),
                    'url_edit' => route('pegawai.edit', $model['id']),
                    'url_destroy' => route('pegawai.destroy', $model['id'])
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);      
    }
}
