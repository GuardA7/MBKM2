@extends('user.layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="text-center">Pelatihan Saya</h2>

    @if($registrations->isEmpty())
        <p class="text-center">Belum ada pelatihan yang diterima.</p>
    @else
        <div class="row">
            @foreach($registrations as $registration)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('img/pelatihan/' . ($registration->pelatihan->gambar ?? 'default.jpg')) }}" class="card-img-top" alt="{{ $registration->pelatihan->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $registration->pelatihan->nama }}</h5>
                            <p class="card-text">{{ Str::limit($registration->pelatihan->deskripsi, 100) }}</p>
                            <p class="card-text"><strong>Tanggal:</strong> {{ $registration->pelatihan->tanggal_pendaftaran }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
