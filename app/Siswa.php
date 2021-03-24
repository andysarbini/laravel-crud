<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['nama_belakang', 'nama_depan', 'jenis_kelamin', 'agama', 'alamat', 'avatar', 'user_id'];

    public function getAvatar()
    {
        if(!$this->avatar){
            return asset('images/default.jpg');
        }
        return asset('images/'.$this->avatar);
    }

    public function mapel() // php artisan tinker; utk uji coba data via terminal, misal relasi
    {
        return $this->belongsToMany(Mapel::class)->withPivot(['nilai'])->withTimeStamps(); // mengambil field nilai di tabel mapel_siswa
    }
}
