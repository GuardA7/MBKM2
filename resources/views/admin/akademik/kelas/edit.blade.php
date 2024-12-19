@extends('admin.layouts.app')

@section('title', 'Halaman Edit Kelas')

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
                <li class="breadcrumb-item">Edit Kelas</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('edit_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Edit Berhasil!</strong> Kelas telah berhasil diedit.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- tabel start -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Edit Kelas</h5>
                        </div>
                        <div class="card-body">

                            <!-- form start edit -->
                            <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- edit nama kelas -->
                                <div class="mb-3">
                                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror"
                                        name="nama_kelas" id="nama_prodi" placeholder="Masukan Nama Kelas"
                                        value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                                    @error('nama_kelas')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit prodi -->
                                <div class="mb-3">
                                    <label for="prodi_id" class="form-label">Prodi</label>
                                    <select name="prodi_id" id="prodi_id"
                                        class="form-select @error('prodi_id') is-invalid @enderror">
                                        <option>-- Pilih Prodi --</option>
                                        @foreach ($prodis as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('prodi_id', $kelas->prodi_id) == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                    @error('prodi_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- buttoon -->
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        update</button>
                                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-sm btn-secondary ms-2"><i
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
