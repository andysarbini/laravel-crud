<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiteController extends Controller
{
    public function home()
    {
        return view('sites.home');
    }

    public function about()
    {
        return view('sites.about');
    }

    public function register()
    {
        return view('sites.register');
    }

    public function postregister(Request $request)
    {
        // insert ke table user
        $user = new \App\User;
        $user->role = 'siswa';
        $user->name = $request->nama_depan;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->remember_token = Str::random(12);
        $user->save();

        // insert ke table siswa
        $request->request->add(['user_id' => $user->id]);
        $siswa = \App\Siswa::create($request->all());

        
        return redirect('/home')->with('sukses', 'Pendaftaran Berhasil');
    }
}
