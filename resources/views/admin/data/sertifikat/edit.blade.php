@extends('admin.layouts.app')

@section('title', 'Edit Sertifikat Pengguna')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Sertifikat Pengguna</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.sertifikat.index') }}"
                        class="text-decoration-none">Sertifikat</a></li>
                <li class="breadcrumb-item active">Edit Sertifikat</li>
            </ol>

            @if (session('edit_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Edit Berhasil!</strong> Sertifikat telah berhasil diedit.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- form edit -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-edit"></i> Edit Sertifikat</h5>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ route('admin.sertifikat.update', ['userId' => $user->id, 'id' => $sertifikat->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- User ID (Hidden) -->
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <!-- User Role (Read-only) -->
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="user_role"
                                        value="{{ ucfirst($user->role) }}" readonly>
                                </div>

                                <!-- Nama Pelatihan -->
                                <div class="mb-3">
                                    <label for="nama_pelatihan" class="form-label">Nama Pelatihan</label>
                                    <input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror"
                                        name="nama_pelatihan" id="nama_pelatihan"
                                        value="{{ old('nama_pelatihan', $sertifikat->nama_pelatihan) }}" required>
                                    @error('nama_pelatihan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tanggal Berlaku -->
                                <div class="mb-3">
                                    <label for="tanggal_berlaku" class="form-label">Tanggal Berlaku</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_berlaku') is-invalid @enderror"
                                        name="tanggal_berlaku" id="tanggal_berlaku"
                                        value="{{ old('tanggal_berlaku', $sertifikat->tanggal_berlaku) }}">
                                    @error('tanggal_berlaku')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tanggal Berakhir -->
                                <div class="mb-3">
                                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                                        name="tanggal_berakhir" id="tanggal_berakhir"
                                        value="{{ old('tanggal_berakhir', $sertifikat->tanggal_berakhir) }}">
                                    @error('tanggal_berakhir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- File Sertifikat -->
                                <div class="mb-3">
                                    <label for="sertifikat_file" class="form-label">File Sertifikat (Optional)</label>
                                    <input type="file" class="form-control" name="sertifikat_file" id="sertifikat_file">
                                    @if ($sertifikat->sertifikat_file)
                                        <p>File: <a href="{{ asset('' . $sertifikat->sertifikat_file) }}"
                                                target="_blank">View File</a></p>
                                    @endif
                                    @error('sertifikat_file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-start">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        Update</button>
                                    <a href="{{ route('admin.sertifikat.index') }}"
                                        class="btn btn-sm btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
