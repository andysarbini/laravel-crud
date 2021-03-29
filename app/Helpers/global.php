<?php
use App\Siswa; // import model
use App\Guru;

function ranking5besar()
{
    $siswa = Siswa::all();
        $siswa->map(function($s) {
            $s->rataRataNilai = $s->rataRataNilai();
            return $s;
        });
        $siswa = $siswa->sortbyDesc('rataRataNilai')->take(5);

    return $siswa;
}

function totalSiswa()
{
    return Siswa::count();
}

function totalGuru()
{
    return Guru::count();
}