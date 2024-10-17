@extends('user.layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Upload Sertifikat</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('sertifikat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama_pelatihan" class="form-label">Nama Pelatihan</label>
            <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_berlaku" class="form-label">Tanggal Berlaku</label>
            <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
            <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
        </div>
        <div class="mb-3">
            <label for="sertifikat_file" class="form-label">Upload Sertifikat (PDF/JPG/JPEG/PNG)</label>
            <input type="file" class="form-control" id="sertifikat_file" name="sertifikat_file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Sertifikat</button>
    </form>
</div>
@endsection
