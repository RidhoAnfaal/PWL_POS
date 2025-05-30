{{-- @extends('layouts.template')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo, apakabar!!!</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        Selamat datang semua, ini adalah halaman utama dari aplikasi ini.
    </div>
</div>
@endsection --}}

@extends ('layouts.template' )

@section('content')

<div class="row">
    <div class="col-md-4">
        <!-- Profile Card -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                @if (session('photo'))
                    <img class="profile-user-img img-fluid img-circle"
                     src="{{ asset('storage/' . session('photo')) }}"
                         alt="User profile picture">
                @else
                    <img class="profile-user-img img-fluid img-circle"
                         src="https://ui-avatars.com/api/?name=User&background=random"
                         alt="Default profile picture">
                @endif

                <h3 class="profile-username text-center mt-2">Ridho Anfa'al</h3>
                <p class="text-muted text-center">Admin</p>

                <ul class="list-group list-group-unbordered mb-3 text-left">
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right">ridho@gmail.com</span>
                    </li>
                    <li class="list-group-item">
                        <b>From</b> <span class="float-right">Polinema</span>
                    </li>
                    <li class="list-group-item">
                        <b>Study Program</b> <span class="float-right">Informatics engineering</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Upload Photo Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upload Foto Profil</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.uploadPhoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="profile_photo">Choose new</label>
                        <input type="file" name="profile_photo" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection