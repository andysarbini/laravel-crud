@extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Siswa</h3>
                        <div class="right">
                        <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#importSiswa">
                            Import Excel
                        </a>
                            <a href="{{('siswa/exportExcel')}}" class="btn btn-sm btn-primary">Excel</a>                                                                            
                            <a href="{{('siswa/exportPdf')}}" class="btn btn-sm btn-primary">PDF</a>                                                                            
                            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal"><i class="lnr lnr-plus-circle"></i></button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover" id="datatable">
                            <thead>
                                <tr>
                                <th>NAMA LENGKAP</th>                                
                                <th>JENIS KELAMIN</th>
                                <th>AGAMA</th>
                                <th>ALAMAT</th>
                                <th>RATA2 NILAI</th>
                                <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data_siswa as $siswa)
                        <tr>
                            <td><a href="{{ url('siswa') }}/{{$siswa->id }}/profile">{{$siswa->nama_depan}}</a></td>
                            <td><a href="{{ ('siswa/')}}{{$siswa->id }}/profile">{{$siswa->nama_belakang}}</a></td>
                            <td>{{$siswa->jenis_kelamin }}</td>
                            <td>{{$siswa->agama }}</td>
                            <td>{{$siswa->alamat }}</td>
                            <td>{{$siswa->rataRataNilai()}}</td>
                            <!-- <td>
                                <a href="{{ url('siswa') }}/{{$siswa->id}}/edit" class="btn btn-warning btn-sm">Edit</a> -->
                                <!-- <a href="{{ url('siswa') }}/{{$siswa->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus?')">Delete</a> -->
                                <!-- <a href="#" class="btn btn-danger btn-sm delete" siswa-id="{{$siswa->id}}">Delete</a>
                            </td> -->
                        </tr>
                        @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Import-->
<div class="modal fade" id="importSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            {!!Form::open(['route' =>'siswa.import', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'])!!}

            {!!Form::file('data_siswa')!!}
        </div>
        <div class="modal-footer">
            
            <input type="submit" class="btn btn-sm btn-primary" value="import">
            </form>
        </div>
        </div>
    </div>
    </div>   

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('siswa/create') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group{{$errors->has('nama_depan') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Nama Depan</label>
                            <input type="text" name="nama_depan" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Depan" value="{{old('nama_depan')}}">
                            @if($errors->has('nama_depan'))
                                <span class="help-block">{{$errors->first('nama_depan')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Belakang</label>
                            <input type="text" name="nama_belakang" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Belakang">
                        </div>                       
                        <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E-mail" value="{{old('email')}}">
                            @if($errors->has('email'))
                                <span class="help-block">{{$errors->first('email')}}</span>
                            @endif
                        </div>                       
                        <div class="form-group{{$errors->has('jenis_kelamin') ? ' has-error' : ''}}">
                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" id="exampleFormControlSelect1">
                                <option value="L" {{(old('jenis_kelamin') == 'L') ? ' selected' : ''}}>Laki-laki</option>
                                <option value="P" {{(old('jenis_kelamin') == 'P') ? ' selected' : ''}}>Perempuan</option>                            
                            </select>
                        </div>
                        <div class="form-group{{$errors->has('agama') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Agama</label>
                            <input type="text" name="agama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Agama" value="{{old('agama')}}">
                            @if($errors->has('agama'))
                                <span class="help-block">{{$errors->first('agama')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                            <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('alamat')}}</textarea>
                        </div>                       
                        <div class="form-group{{$errors->has('avatar') ? ' has-error' : ''}}">
                            <label for="exampleFormControlTextarea1">Avatar</label>
                            <input type="file" name="avatar" class="form-control" id="">
                            @if($errors->has('avatar'))
                                <span class="help-block">{{$errors->first('avatar')}}</span>
                            @endif
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                    </form>

                </div>
            </div>         
@stop  

@section('footer')
    <script>
        $(document).ready(function(){     // jalankan function jk document di load
            $('#datatable').DataTable({
                processing:true,
                serverside:true,
                ajax:"{{route('ajax.get.data.siswa')}}",
                columns:[
                    {data:'nama_lengkap', name:'nama_lengkap'},      
                    {data:'jenis_kelamin', name:'jenis_kelamin'},
                    {data:'agama', name:'agama'},
                    {data:'alamat', name:'alamat'},
                    {data:'rata2_nilai', name:'rata2_nilai'},
                    {data:'aksi', name:'aksi'}
                ]
            });

            $('.delete').click(function(){ // jk class delete di klik, mk jalankan function
                var siswa_id = $(this).attr('siswa-id'); // variabel siswa_id mengambil atribut id dri element diatas
                swal({
                    title: "Are you sure?",
                    text: "data "+siswa_id+" will be delete",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => { // promise di javascript
                        console.log(willDelete);
                        if (willDelete) {
                            window.location = "siswa/"+siswa_id+"/delete";
                        }
                });
            });
        });

    </script>
@stop
        