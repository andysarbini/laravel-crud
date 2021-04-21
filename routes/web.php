<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('kirimemail', function(){
//     \Mail::raw('halo siswa baru', function ($message) {
//         // $message->from('john@johndoe.com', 'John Doe');
//         // $message->sender('john@johndoe.com', 'John Doe');
//         $message->to('kangandy09@gmail.com', 'Andy');
//         // $message->cc('john@johndoe.com', 'John Doe');
//         // $message->bcc('john@johndoe.com', 'John Doe');
//         // $message->replyTo('john@johndoe.com', 'John Doe');
//         $message->subject('Pendaftaran siswa');
//         // $message->priority(3);
//         // $message->attach('pathToFile');
//     });
// });

// Route::get('/', 'SiteController@home');
Route::get('/home', 'SiteController@home');
Route::get('/register', 'SiteController@register');
Route::post('/postregister', 'SiteController@postregister');
Route::get('/about', 'SiteController@about');


Route::get('/login', 'AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware' => ['auth', 'checkRole:admin']], function(){
    Route::get('/siswa', 'SiswaController@index');
    Route::post('/siswa/create', 'SiswaController@create');
    Route::get('/siswa/{siswa}/edit', 'SiswaController@edit');
    Route::post('/siswa/{siswa}/update', 'SiswaController@update');
    Route::get('/siswa/{id}/delete', 'SiswaController@delete');
    Route::get('/siswa/{siswa}/profile', 'SiswaController@profile')->name('profile'); // tadinya 'id' dinamis tp kita ganti dengan  nama model
    Route::post('siswa/{siswa}/addnilai', 'SiswaController@addnilai');
    Route::get('/siswa/{id}/{idmapel}/deletenilai', 'SiswaController@deletenilai');
    Route::get('/siswa/exportExcel', 'SiswaController@exportExcel');
    Route::get('/siswa/exportPdf', 'SiswaController@exportPdf'); // case sensitif
    Route::post('/siswa/import', 'SiswaController@importexcel')->name('siswa.import'); // case sensitif
    Route::get('/guru/{id}/profile', 'GuruController@profile');
    Route::get('/posts', 'PostController@index')->name('posts.index');
    Route::get('post/add',[
        'uses' => 'PostController@add',
        'as' => 'post.add',
    ]);
    Route::post('post/create', [
        'uses' => 'PostController@create',
        'as' => 'post.create',
    ]);
});

Route::group(['middleware' => ['auth', 'checkRole:admin,siswa']], function(){ // array admin dan siswa jangan pakai spasi
    Route::get('/dashboard', 'DashboardController@index');
});

Route::group(['middleware' => ['auth', 'checkRole:siswa']], function(){
    Route::get('profilsaya', 'SiswaController@profilsaya');
});

Route::get('getdatasiswa',[
    'uses' => 'SiswaController@getdatasiswa',
    'as' => 'ajax.get.data.siswa',
]);

Route::get('/{slug}',[ // simpan di akhir, krn jk disimpan diawal akan di load dahulu
    'uses' => 'SiteController@singlepost', // uses: menggunakan controller apa, halaman singlepost
    'as' => 'site.single.post'
]);