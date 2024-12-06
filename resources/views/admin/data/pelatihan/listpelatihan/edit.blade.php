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
                <li class="breadcrumb-item">Edit Pelatihan</li>
            </ol>

            @if (session('edit_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Edit Berhasil!</strong> Pelatihan telah berhasil diedit.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- tabel start -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Edit Pelatihan</h5>
                        </div>
                        <div class="card-body">

                            <!-- form start create -->
                            <form action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- edit gambar pelatihan -->
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Pelatihan</label>
                                    <div class="mb-3">
                                        <img id="imagePreview"
                                            src="{{ asset('img/pelatihan/gambar/' . $pelatihan->gambar) }}"
                                            alt="Gambar Pelatihan" style="max-width: 200px; max-height: 200px;">
                                        <!-- Display the name of the existing file if it exists -->
                                    </div>
                                    <span id="fileName" style="pointer-events: none;">
                                        {{ $pelatihan->gambar ? $pelatihan->gambar : 'Belum ada file yang dipilih' }}
                                    </span>

                                    <div class="position-relative">
                                        <input type="file"
                                            class=" mb-2 form-control @error('gambar') is-invalid @enderror" name="gambar"
                                            id="gambar" accept="image/*" onchange="previewImage()"
                                            style="padding-left: 10px;">
                                        <div class="form-text text-danger">Png, Jpg, Maksimal : 2 mb.</div>
                                    </div>

                                    @error('gambar')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit nama pelatihan -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pelatihan</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" id="nama" placeholder="Masukan Nama Pelatihan"
                                        value="{{ old('nama', $pelatihan->nama) }}">
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit lsp -->
                                <div class="mb-3">
                                    <label for="lsp" class="form-label">LSP</label>
                                    <select class="form-select @error('lsp_id') is-invalid @enderror" name="lsp_id"
                                        id="lsp">
                                        <option value="">Pilih LSP</option>
                                        @foreach ($lsps as $lsp)
                                            <option value="{{ $lsp->id }}"
                                                {{ old('lsp_id', $pelatihan->lsp_id) == $lsp->id ? 'selected' : '' }}>
                                                {{ $lsp->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('lsp_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit kategori pelatihan -->
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror"
                                        name="kategori_id" id="kategori">
                                        <option>Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ old('kategori_id', $pelatihan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- jenis pelatihan -->
                                <div class="mb-3">
                                    <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
                                    <select class="form-select @error('jenis_pelatihan') is-invalid @enderror"
                                        name="jenis_pelatihan" id="jenis_pelatihan">
                                        <option value="" disabled selected>Pilih Jenis Pelatihan</option>
                                        <option value="offline"
                                            {{ (old('jenis_pelatihan') ?? $pelatihan->jenis_pelatihan) == 'offline' ? 'selected' : '' }}>
                                            Offline</option>
                                        <option value="online"
                                            {{ (old('jenis_pelatihan') ?? $pelatihan->jenis_pelatihan) == 'online' ? 'selected' : '' }}>
                                            Online</option>
                                    </select>
                                    @error('jenis_pelatihan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                                        placeholder="Masukan Deskripsi">{{ old('deskripsi', $pelatihan->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit harga -->
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                        name="harga" id="harga" placeholder="Masukan Harga Pelatihan"
                                        value="{{ old('harga', $pelatihan->harga) }}">
                                    @error('harga')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit kuota -->
                                <div class="mb-3">
                                    <label for="kuota" class="form-label">Kuota</label>
                                    <input type="number" class="form-control @error('kuota') is-invalid @enderror"
                                        name="kuota" id="kuota" placeholder="Masukan Kuota Peserta"
                                        value="{{ old('kuota', $pelatihan->kuota) }}">
                                    @error('kuota')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit tanggal pendaftaran -->
                                <div class="mb-3">
                                    <label for="tanggal_pendaftaran" class="form-label">Mulai Pendaftaran</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_pendaftaran') is-invalid @enderror"
                                        name="tanggal_pendaftaran" id="tanggal_pendaftaran"
                                        value="{{ old('tanggal_pendaftaran', $pelatihan->tanggal_pendaftaran) }}">
                                    @error('tanggal_pendaftaran')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit berakhir pendaftaran -->
                                <div class="mb-3">
                                    <label for="berakhir_pendaftaran" class="form-label">Berakhir Pendaftaran</label>
                                    <input type="date"
                                        class="form-control @error('berakhir_pendaftaran') is-invalid @enderror"
                                        name="berakhir_pendaftaran" id="berakhir_pendaftaran"
                                        value="{{ old('berakhir_pendaftaran', $pelatihan->berakhir_pendaftaran) }}">
                                    @error('berakhir_pendaftaran')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit jadwal pelatihan -->
                                <div class="mb-3">
                                    <label for="jadwal_pelatihan_mulai" class="form-label">jadwal awal pelatihan</label>
                                    <input type="date"
                                        class="form-control @error('jadwal_pelatihan_mulai') is-invalid @enderror"
                                        name="jadwal_pelatihan_mulai" id="jadwal_pelatihan_mulai"
                                        value="{{ old('jadwal_pelatihan_mulai', $pelatihan->jadwal_pelatihan_mulai) }}">
                                    @error('jadwal_pelatihan_mulai')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- edit selesai pelatihan -->
                                <div class="mb-3">
                                    <label for="jadwal_pelatihan_selesai" class="form-label">Jadwal Selesai
                                        Pelatihan</label>
                                    <input type="date"
                                        class="form-control @error('jadwal_pelatihan_selesai') is-invalid @enderror"
                                        name="jadwal_pelatihan_selesai" id="jadwal_pelatihan_selesai"
                                        value="{{ old('jadwal_pelatihan_selesai', $pelatihan->jadwal_pelatihan_selesai) }}">
                                    @error('jadwal_pelatihan_selesai')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- button -->
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        Update</button>
                                    <a href="{{ route('admin.pelatihan.index') }}"
                                        class="btn btn-sm btn-secondary ms-2"><i class="fas fa-arrow-left"></i>
                                        Kembali</a>
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
