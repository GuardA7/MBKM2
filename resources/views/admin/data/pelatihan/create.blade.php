@extends('admin.layouts.app')

@section('title', 'Tambah Pelatihan')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.pelatihan.index') }}" class="text-decoration-none">Pelatihan</a></li>
                <li class="breadcrumb-item">Tambah Pelatihan</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Pelatihan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Gambar Pelatihan -->
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Pelatihan</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Masukan gambar Pelatihan" required>
                                    <div class="form-text text-danger">Png, Jpg, Maksimal : 2 mb.</div>
                                    @error('gambar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nama Pelatihan -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pelatihan</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama Pelatihan" required>
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Jenis Pelatihan -->
                                <div class="mb-3">
                                    <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
                                    <input type="text" class="form-control" name="jenis_pelatihan" id="jenis_pelatihan" placeholder="Masukan Jenis Pelatihan" required>
                                    @error('jenis_pelatihan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukan Deskripsi" required></textarea>
                                    @error('deskripsi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tanggal Pendaftaran -->
                                <div class="mb-3">
                                    <label for="tanggal_pendaftaran" class="form-label">Mulai Pendaftaran</label>
                                    <input type="date" class="form-control" name="tanggal_pendaftaran" id="tanggal_pendaftaran" required>
                                    @error('tanggal_pendaftaran')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Berakhir Pendaftaran -->
                                <div class="mb-3">
                                    <label for="berakhir_pendaftaran" class="form-label">Berakhir Pendaftaran</label>
                                    <input type="date" class="form-control" name="berakhir_pendaftaran" id="berakhir_pendaftaran" required>
                                    @error('berakhir_pendaftaran')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Harga -->
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" name="harga" id="harga" placeholder="Masukan Harga Pelatihan" required>
                                    @error('harga')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Kuota -->
                                <div class="mb-3">
                                    <label for="kuota" class="form-label">Kuota</label>
                                    <input type="number" class="form-control" name="kuota" id="kuota" placeholder="Masukan Kuota Peserta" required>
                                    @error('kuota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- LSP -->
                                <div class="mb-3">
                                    <label for="lsp" class="form-label">LSP</label>
                                    <select class="form-select" name="lsp_id" id="lsp" required>
                                        <option value="">Pilih LSP</option>
                                        @foreach ($lsps as $lsp)
                                            <option value="{{ $lsp->id }}">{{ $lsp->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('lsp_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Kategori -->
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" name="kategori_id" id="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                    <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
