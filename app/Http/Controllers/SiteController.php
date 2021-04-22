<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\post;
use App\Mail\NotifPendaftaranSiswa;

class SiteController extends Controller
{
    public function home()
    {
        $posts = Post::all();
        return view('sites.home', compact(['posts']));
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

        \Mail::to($user->email)->send(new NotifPendaftaranSiswa);        
        
        return redirect('/home')->with('sukses', 'Pendaftaran Berhasil');
    }

    public function singlepost($slug)
    {
        $post = Post::where('slug','=',$slug)->first();
        return view('sites.singlepost', compact(['post']));
    }
}
