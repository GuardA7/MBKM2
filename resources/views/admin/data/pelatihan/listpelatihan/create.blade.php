@extends('admin.layouts.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.pelatihan.index') }}" class="text-decoration-none">Pelatihan</a>
                </li>
                <li class="breadcrumb-item">Tambah Pelatihan</li>
            </ol>

            <!-- tabel start -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Pelatihan</h5>
                        </div>
                        <div class="card-body">

                            <!-- form start create -->
                            <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- create gambar pelatihan -->
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Pelatihan</label>
                                    <input type="file" class="form-control  @error('gambar') is-invalid @enderror" name="gambar" id="gambar" placeholder="Masukan gambar Pelatihan">
                                    <div class="form-text text-danger">Png, Jpg, Maksimal : 2 mb.</div>
                                    @error('gambar')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create nama pelatihan -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pelatihan</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" id="nama" placeholder="Masukan Nama Pelatihan"
                                        value="{{ old('nama') }}">
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create lsp -->
                                <div class="mb-3">
                                    <label for="lsp" class="form-label">LSP</label>
                                    <select class="form-select @error('lsp_id') is-invalid @enderror" name="lsp_id" id="lsp">
                                        <option value="">Pilih LSP</option>
                                        @foreach ($lsps as $lsp)
                                            <option value="{{ $lsp->id }}" {{ old('lsp_id') }}>{{ $lsp->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('lsp_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create kategori pelatihan -->
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror" name="kategori_id" id="kategori">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_id') }}>{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create jenis pelatihan -->
                                <div class="mb-3">
                                    <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
                                    <input type="text" class="form-control @error('jenis_pelatihan') is-invalid @enderror"
                                        name="jenis_pelatihan" id="jenis_pelatihan" placeholder="Masukan Jenis Pelatihan"
                                        value="{{ old('jenis_pelatihan') }}">
                                    @error('jenis_pelatihan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" placeholder="Masukan Deskripsi">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create harga -->
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" id="harga" placeholder="Masukan Harga Pelatihan" value="{{ old('harga') }}">
                                    @error('harga')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create kuota -->
                                <div class="mb-3">
                                    <label for="kuota" class="form-label">Kuota</label>
                                    <input type="number" class="form-control @error('kuota') is-invalid @enderror" name="kuota" id="kuota" placeholder="Masukan Kuota Peserta" value="{{ old('kuota') }}">
                                    @error('kuota')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create tanggal pendaftaran -->
                                <div class="mb-3">
                                    <label for="tanggal_pendaftaran" class="form-label">Mulai Pendaftaran</label>
                                    <input type="date" class="form-control @error('tanggal_pendaftaran') is-invalid @enderror" name="tanggal_pendaftaran" id="tanggal_pendaftaran" value="{{ old('tanggal_pendaftaran') }}">
                                    @error('tanggal_pendaftaran')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- create berakhir pendaftaran -->
                                <div class="mb-3">
                                    <label for="berakhir_pendaftaran" class="form-label">Berakhir Pendaftaran</label>
                                    <input type="date" class="form-control @error('berakhir_pendaftaran') is-invalid @enderror" name="berakhir_pendaftaran" id="berakhir_pendaftaran" value="{{ old('berakhir_pendaftaran') }}">
                                    @error('berakhir_pendaftaran')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- button -->
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        Tambah</button>
                                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-secondary ms-2"><i
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
