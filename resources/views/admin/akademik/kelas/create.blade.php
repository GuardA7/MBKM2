@extends('admin.layouts.app')

@section('title', 'Halaman Tambah Kelas')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kelas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.prodi.index') }}" class="text-decoration-none">Kelas</a>
                </li>
                <li class="breadcrumb-item">Tambah Kelas</li>
            </ol>

            <!-- tabel start -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Kelas</h5>
                        </div>
                        <div class="card-body">

                            <!-- form start create -->
                            <form action="{{ route('admin.kelas.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- create nama kelas -->
                                <div class="mb-3">
                                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror"
                                        name="nama_kelas" id="nama_prodi" placeholder="Masukan Nama Kelas"
                                        value="{{ old('nama_kelas') }}">
                                    @error('nama_kelas')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create prodi id -->
                                <div class="mb-3">
                                    <label for="prodi_id" class="form-label">Jurusan</label>
                                    <select name="prodi_id" id="prodi_id"
                                        class="form-select @error('prodi_id') is-invalid @enderror">
                                        <option>-- Pilih Prodi --</option>
                                        @foreach ($prodis as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('prodi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('prodi_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- button -->
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        Tambah</button>
                                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-sm btn-secondary ms-2"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>

                            </form>
                            <!-- form end create -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- tabel end -->

        </div>
    </main>
@endsection
