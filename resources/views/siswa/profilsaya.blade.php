@extends('layouts.master')

@section('header')

@stop

    @section('content')
    <div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					@if(session('sukses'))
					<div class="alert alert-success" role="alert">
						{{session('sukses')}}
					</div>
					@endif

					@if(session('error'))
					<div class="alert alert-danger" role="alert">
						{{session('error')}}
					</div>
					@endif
					<div class="panel panel-profile">
						<div class="clearfix">
							<!-- LEFT COLUMN -->
							<div class="profile-left">
								<!-- PROFILE HEADER -->
								<div class="profile-header">
									<div class="overlay"></div>
									<div class="profile-main">
										<img width="100" height="100" src="{{$siswa->getAvatar()}}" class="img-circle" alt="Avatar">
										<h3 class="name">{{$siswa->nama_depan}}</h3>
										<span class="online-status status-available">Available</span>
									</div>
									<div class="profile-stat">
										<div class="row">
											<div class="col-md-4 stat-item">
												{{$siswa->mapel->count()}} <span>Mata Pelajaran</span>
											</div>
											<div class="col-md-4 stat-item">
												{{$siswa->rataRataNilai()}} <span>Rata-rata Nilai</span>
											</div>
											<div class="col-md-4 stat-item">
												2174 <span>Points</span>
											</div>
										</div>
									</div>
								</div>
								<!-- END PROFILE HEADER -->
								<!-- PROFILE DETAIL -->
								<div class="profile-detail">
									<div class="profile-info">
										<h4 class="heading">Data Pribadi</h4>
										<ul class="list-unstyled list-justify">
											<li>Jenis Kelamin <span>{{$siswa->jenis_kelamin}}</span></li>
											<li>Agama <span>{{$siswa->agama}}</span></li>
											<li>Alamat <span>{{$siswa->alamat}}</span></li>
											
										</ul>
									</div>
									
									<!-- {{ url('siswa') }}/{{$siswa->id}}/edit -->
									<div class="text-center"><a href="{{ url('siswa') }}/{{$siswa->id}}/edit" class="btn btn-warning">Edit Profile</a></div>
								</div>
								<!-- END PROFILE DETAIL -->
							</div>
							<!-- END LEFT COLUMN -->
							<!-- RIGHT COLUMN -->
							<div class="profile-right">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
									Tambah Nilai
								</button>								
								<!-- TABBED CONTENT -->
								<div class="panel">
									<div class="panel-heading">
										<h3 class="panel-title">Mata Pelajaran</h3>
									</div>
									<div class="panel-body">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>KODE</th>
													<th>NAMA</th>
													<th>SEMESTER</th>
													<th>NILAI</th>
													<th>GURU</th>
													<th>AKSI</th>
												</tr>
											</thead>
											<tbody>
											@foreach($siswa->mapel as $mapel)
												<tr>
													<td>{{$mapel->kode}}</td>
													<td>{{$mapel->nama}}</td>
													<td>{{$mapel->semester}}</td>
													<td><a href="#" class="nilai" data-type="text" data-pk="{{$mapel->id}}" data-url="{{ url('/api/siswa') }}/{{$siswa->id}}/editnilai" data-title="Masukkan Nilai">{{$mapel->pivot->nilai}}</a></td>
													<td><a href="{{ url('guru') }}/{{$mapel->guru_id}}/profile" >{{$mapel->guru->nama}}</a></td>
													<td><a href="{{ url('siswa') }}/{{$siswa->id}}/{{$mapel->id}}/deletenilai" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus?')">Delete</a></td>
												</tr>
											@endforeach	
											</tbody>
										</table>
									</div>
								</div>
								<!-- END TABBED CONTENT -->
								<div class="panel">
									<div id="chartNilai"></div>
								</div>
							</div>
							<!-- END RIGHT COLUMN -->
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>

		
@stop

@section('footer')
<!-- skrip ini akan disisipkan kedalam file master pada yield footer -->

	<script>
	</script> 
@stop