<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Validator,Redirect,Response,Session;
Use Alert;

class AuthController extends Controller
{
    //
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        $firebaseSession = Session::get('token');
        if (!empty($firebaseSession)) {
            return redirect('dashboard');
        } else {
            return view('admin.login');
        }
    }

    public function login(Request $request)
    {
        session_start();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ],[

            'email.required' => 'E-Mail harus di isi',
            'email.email' => 'E-Mail tidak sesuai format',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 8 karakter',

        ]);

        $validator->validate();

        $email = $request->email;
        $password = $request->password;

        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);
            $idToken = $signInResult->idToken();
            $token = Session::put('token', $idToken);
            $result = $signInResult;
            return response()->json(array('msg'=> 'login'));
            // return redirect('dashboard');
        } catch (\Throwable $th) {
            $filed = '';
            $msgError = '';
            $result = strtolower($th->getMessage());
            if (strstr( $result, 'email' )) {
                $filed = 'email';
                $msgError = 'E-Mail tidak ditemukan';
            } else if (strstr( $result, 'password' )) {
                $filed = 'password';
                $msgError = 'Password tidak sesuai';
            } else {
                //
            }

            return response()->json(array('msg'=> 'login errors', 'key' => $filed, 'value' => $msgError));
            // return Redirect::back()->withInput()->withErrors([$filed => $msgError]);
        }

        // $signIn = $signInResult->idToken(); // string|null
        // $signIn = $signInResult->accessToken(); // string|null
        // $signIn = $signInResult->refreshToken(); // string|null
        // $signIn = $signInResult->data(); // array
        // $signIn = $signInResult->asTokenResponse(); // array

    }

    public function logout()
    {
        try {
            Session::flush();
            return redirect('login');
        } catch (\Throwable $th) {
            return Redirect::back();
        }        
    }
}
