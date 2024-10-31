@extends('admin.layouts.app')

@section('title', 'Edit Pelatihan')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pelatihan.index') }}"
                        class="text-decoration-none">Pelatihan</a></li>
                <li class="breadcrumb-item active">Edit Pelatihan</li>
            </ol>

            @if (session('edit_success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Update Berhasil!</strong> Pelatihan telah berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-edit"></i> Edit Pelatihan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Gambar Pelatihan -->
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Pelatihan</label>
                                    <div class="mb-3">
                                        <img id="imagePreview" src="{{ asset('img/pelatihan/' . $pelatihan->gambar) }}"
                                            alt="Gambar Pelatihan" style="max-width: 200px; max-height: 200px;">
                                    </div>

                                    <div class="position-relative">
                                        <input type="file" class=" mb-2 form-control @error('gambar') is-invalid @enderror"
                                            name="gambar" id="gambar" accept="image/*" onchange="previewImage()"
                                            style="padding-left: 10px;">

                                            <!-- Display the name of the existing file if it exists -->
                                            <span id="fileName"
                                                style="pointer-events: none;">
                                                {{ $pelatihan->gambar ? $pelatihan->gambar : 'Belum ada file yang dipilih' }}
                                            </span>
                                    </div>

                                    @error('gambar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                <!-- Nama Pelatihan -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pelatihan</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" id="nama" value="{{ old('nama', $pelatihan->nama) }}" required>
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Jenis Pelatihan -->
                                <div class="mb-3">
                                    <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
                                    <input type="text"
                                        class="form-control @error('jenis_pelatihan') is-invalid @enderror"
                                        name="jenis_pelatihan" id="jenis_pelatihan"
                                        value="{{ old('jenis_pelatihan', $pelatihan->jenis_pelatihan) }}" required>
                                    @error('jenis_pelatihan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="5"
                                        required>{{ old('deskripsi', $pelatihan->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tanggal Pendaftaran -->
                                <div class="mb-3">
                                    <label for="tanggal_pendaftaran" class="form-label">Mulai Pendaftaran</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_pendaftaran') is-invalid @enderror"
                                        name="tanggal_pendaftaran" id="tanggal_pendaftaran"
                                        value="{{ old('tanggal_pendaftaran', $pelatihan->tanggal_pendaftaran) }}" required>
                                    @error('tanggal_pendaftaran')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Berakhir Pendaftaran -->
                                <div class="mb-3">
                                    <label for="berakhir_pendaftaran" class="form-label">Berakhir Pendaftaran</label>
                                    <input type="date"
                                        class="form-control @error('berakhir_pendaftaran') is-invalid @enderror"
                                        name="berakhir_pendaftaran" id="berakhir_pendaftaran"
                                        value="{{ old('berakhir_pendaftaran', $pelatihan->berakhir_pendaftaran) }}"
                                        required>
                                    @error('berakhir_pendaftaran')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Harga -->
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                        name="harga" id="harga" value="{{ old('harga', $pelatihan->harga) }}"
                                        required>
                                    @error('harga')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Kuota -->
                                <div class="mb-3">
                                    <label for="kuota" class="form-label">Kuota</label>
                                    <input type="number" class="form-control @error('kuota') is-invalid @enderror"
                                        name="kuota" id="kuota" value="{{ old('kuota', $pelatihan->kuota) }}"
                                        required>
                                    @error('kuota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- LSP -->
                                <div class="mb-3">
                                    <label for="lsp_id" class="form-label">LSP</label>
                                    <select class="form-select @error('lsp_id') is-invalid @enderror" name="lsp_id"
                                        id="lsp_id" required>
                                        @foreach ($lsps as $lsp)
                                            <option value="{{ $lsp->id }}"
                                                {{ old('lsp_id', $pelatihan->lsp_id) == $lsp->id ? 'selected' : '' }}>
                                                {{ $lsp->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('lsp_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Kategori -->
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror"
                                        name="kategori_id" id="kategori_id" required>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ old('kategori_id', $pelatihan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                        Simpan</button>
                                    <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary ms-2"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
