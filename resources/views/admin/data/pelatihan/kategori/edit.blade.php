@extends('admin.layouts.app')

@section('title', 'Halaman Edit Kategori')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kategori Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">Kategori Pelatihan</a>
                </li>
                <li class="breadcrumb-item">Edit Kategori Pelatihan</li>
            </ol>

            <!-- tabel start -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Edit Kategori Pelatihan</h5>
                        </div>
                        <div class="card-body">

                            <!-- form start edit -->
                            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- edit nama kategori -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Kategori Pelatihan</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" id="nama" placeholder="Masukan Nama Kategroi Pelatihan"
                                        value="{{ old('nama', $kategori->nama) }}">
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- button -->
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        update</button>
                                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-secondary ms-2"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>

                            </form>
                            <!-- form end edit -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- tabel end -->

        </div>
    </main>
@endsection
