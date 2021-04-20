<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Siswa;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('cari'))
        {
            $data_siswa = \App\Siswa::where('nama_depan','LIKE','%' .$request->cari. '%')->paginate(20); // server side
            // $data_siswa = \App\Siswa::where('nama_depan','LIKE','%' .$request->cari. '%')->get();
        }
        else
        {
            // $data_siswa = \App\Siswa::paginate(20);
            $data_siswa = \App\Siswa::all();
        }      

        return view('siswa.index', ['data_siswa' => $data_siswa]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[ // $this itu utk memanggil objek/class siswa yg sudah terbentuk
            'nama_depan' => 'required|min:5',
            'email' => 'required|unique:users',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'avatar' => 'mimes:jpg,png'
        ]);

        // insert ke table user
        $user = new \App\User;
        $user->role = 'siswa';
        $user->name = $request->nama_depan;
        $user->email = $request->email;
        $user->password = bcrypt('rahasia');
        $user->remember_token = Str::random(12);
        $user->save();

        // insert ke table siswa
        $request->request->add(['user_id' => $user->id]);
        $siswa = \App\Siswa::create($request->all());

        if($request->hasFile('avatar')){
            $request->file('avatar')->move('images/',$request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }

        return redirect('/siswa')->with('sukses', 'Data berhasil diinput');
    }

    public function edit(Siswa $siswa)
    {
        // $siswa = \App\Siswa::find($id);  App dihapus krn sudah di panggil di atas menggunakan use
        return view('siswa.edit',['siswa' => $siswa]);
    }
    
    public function update(Request $request, $id)
    {
        // dd($request->all());
        
        $siswa->update($request->all());
        if($request->hasFile('avatar')){
            $request->file('avatar')->move('images/',$request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }
        return redirect('/siswa')->with('sukses', 'Data berhasil diupdate');
    }

    public function delete($id) // id nya ditangkap didalam parameter
    {
        $siswa = Siswa::find($id); // deklarasi objek siswa
        $siswa->delete($siswa);
        return redirect('/siswa')->with('sukses', 'Data berhasil dihapus');
    }

    public function profile(Siswa $siswa) // pengganti parameter id, jd tidak perlu lg deklarasi siswa sperti method delete
    { 
        $matapelajaran = \App\Mapel::all();
    
        // menyiapkan data untuk chart berupa array
        $categories = [];
        $data = [];
        foreach($matapelajaran as $mp)
        {
            if($siswa->mapel()->wherePivot('mapel_id', $mp->id)->first()){
                $categories[] = $mp->nama;
                $data[] = $siswa->mapel()->wherePivot('mapel_id',$mp->id)->first()->pivot->nilai;
            }
        }

        return view('siswa.profile',['siswa' => $siswa, 'matapelajaran' =>$matapelajaran, 'categories' => $categories, 'data' => $data]);
    
    }

    public function addnilai(Request $request, Siswa $siswa)
    {
        if($siswa->mapel()->where('mapel_id', $request->mapel)->exists())
        {
            return redirect()->route('profile', $siswa)->with('error', 'Mata pelajaran sudah ada');            
        }
        $siswa->mapel()->attach($request->mapel,['nilai'=> $request->nilai]);

        // return Redirect('/siswa', $idsiswa,'/profile')->with('sukses', 'Data nilai berhasil dimasukkan');
        return redirect()->route('profile', $siswa)->with('sukses', 'Data nilai berhasil dimasukkan');
    }

    public function deletenilai($idsiswa, $idmapel)
    {
        $siswa = \App\Siswa::find($idsiswa);
        $siswa->mapel()->detach($idmapel); // lepas dari pivot
        return redirect()->back()->with('sukses', 'Data nilai berhasil dihapus');
    }

    public function exportExcel() 
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }

    public function exportPdf()
    {
        $siswa = \App\Siswa::all();
        $pdf = PDF::loadView('export.siswapdf', ['siswa' => $siswa]);
        return $pdf->download('siswa.pdf');
    }

    public function getdatasiswa()
    {
        $siswa = Siswa::select('siswa.*');
        return \DataTables::eloquent($siswa)
        ->addColumn('nama_lengkap', function($s){
            return $s->nama_depan.' '.$s->nama_belakang;
        })
        ->addColumn('rata2_nilai', function($s){ // $s, mewakili 1 siswa yg akan di looping
            return $s->rataRataNilai();
        })
        ->addColumn('aksi', function($s){
            return '<a href="siswa/'.$s->id.'/profile/" class="btn btn-warning">Edit</a>';
        })
        ->rawColumns(['nama_lengkap', 'rata2_nilai', 'aksi']) // setip addcolumn masukkan kedalam array
        ->toJson();
    }

    public function profilsaya()
    { 
        $siswa = auth()->user()->siswa;
        return view('siswa.profilsaya', compact(['siswa']));
    }
}
