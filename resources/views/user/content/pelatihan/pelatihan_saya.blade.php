{{-- resources/views/user/pelatihan_saya.blade.php --}}
@extends('user.layouts.app')

@section('content')
<div class="container">
    <h1>Pelatihan Saya</h1>

    @if ($pelatihans->isEmpty())
        <p>Anda belum mendaftar pelatihan apapun.</p>
    @else
        <div class="row">
            @foreach ($pelatihans as $pelatihan)
                <div class="col-12">
                    <div class="card position-relative" style="min-height: 150px;">
                        <div class="card-body d-flex">
                            <div class="me-4" style="width: 100px; height: 100px;">
                                <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}" class="img-fluid rounded" alt="Gambar Pelatihan" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">{{ $pelatihan->nama }}</h5>
                                <p class="card-text mb-1"><strong>Jenis:</strong> {{ $pelatihan->jenis_pelatihan }}</p>
                                <p class="card-text mb-1"><strong>Harga:</strong> Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                                <p class="card-text mb-1">
                                    <strong>Status Pendaftaran:</strong> {{ ucfirst($pelatihan->pivot->status_pendaftaran) }}
                                </p>
                            </div>
                            {{-- Button positioned at the bottom-right corner --}}
                            <a href="#"
                               class="btn btn-primary position-absolute"
                               style="bottom: 15px; right: 15px;">
                               Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
