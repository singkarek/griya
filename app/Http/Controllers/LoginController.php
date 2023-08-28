<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        // return $request->all();
        

       $credentials = $request->validate([
            'karyawan_nip' => 'required',
            'password' => 'required'
        ]);

        // dd($credentials);

        // dd('berhasil login');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            if(auth()->user()->division_id == 1){
                return redirect()->intended('/sales');
            }else if(auth()->user()->division_id == 2){
                return redirect()->intended('/teknisi');
            }else{
                return redirect()->intended('/admin');
            }
            // @dd($request);
        }
        
        return back()->with('error', 'Login gagal !!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}
