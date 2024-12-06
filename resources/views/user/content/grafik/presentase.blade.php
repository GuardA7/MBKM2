@extends('user.layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Dashboard Sertifikat</h1>

    <!-- Filters Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Filter Data</h5>
            <form method="GET" action="{{ url('chart') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="role" class="form-label">User Type</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">Pilih Tipe User</option>
                            <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="jurusan_id" class="form-label">Jurusan</label>
                        <select name="jurusan_id" id="jurusan_id" class="form-control" {{ request('role') ? '' : 'disabled' }}>
                            <option value="">Pilih Jurusan</option>
                            @foreach ($jurusan as $j)
                                <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 {{ request('role') == 'mahasiswa' && request('jurusan_id') ? '' : 'd-none' }}" id="prodi-container">
                        <label for="prodi_id" class="form-label">Prodi</label>
                        <select name="prodi_id" id="prodi_id" class="form-control" {{ request('role') == 'mahasiswa' && request('jurusan_id') ? '' : 'disabled' }}>
                            <option value="">Pilih Prodi</option>
                            @foreach ($jurusan as $j)
                                @if ($j->id == request('jurusan_id'))
                                    @foreach ($j->prodis as $p)
                                        <option value="{{ $p->id }}" {{ request('prodi_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_prodi }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 {{ request('prodi_id') ? '' : 'd-none' }}" id="kelas-container">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-control" {{ request('prodi_id') ? '' : 'disabled' }}>
                            <option value="">Pilih Kelas</option>
                            @foreach ($jurusan as $j)
                                @foreach ($j->prodis as $p)
                                    @if ($p->id == request('prodi_id'))
                                        @foreach ($p->kelas as $k)
                                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary w-50">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Grafik Sertifikat Upload</h5>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const jurusan = @json($jurusan);

    // Dropdown filtering
    $('#role').on('change', function () {
        const role = $(this).val();

        // Reset all filters
        $('#jurusan_id').val('').prop('disabled', true);
        $('#prodi_id').html('<option value="">Pilih Prodi</option>').prop('disabled', true);
        $('#kelas_id').html('<option value="">Pilih Kelas</option>').prop('disabled', true);

        $('#prodi-container').addClass('d-none');
        $('#kelas-container').addClass('d-none');

        // Enable jurusan if role is selected
        if (role) {
            $('#jurusan_id').prop('disabled', false);
        }
    });

    $('#jurusan_id').on('change', function () {
        const jurusanId = $(this).val();
        const role = $('#role').val();

        // Reset Prodi and Kelas
        $('#prodi_id').html('<option value="">Pilih Prodi</option>').prop('disabled', true);
        $('#kelas_id').html('<option value="">Pilih Kelas</option>').prop('disabled', true);
        $('#prodi-container').addClass('d-none');
        $('#kelas-container').addClass('d-none');

        if (role === 'mahasiswa' && jurusanId) {
            // Populate Prodi dropdown
            const prodis = jurusan.find(j => j.id == jurusanId)?.prodis || [];
            prodis.forEach(prodi => {
                $('#prodi_id').append(`<option value="${prodi.id}">${prodi.nama_prodi}</option>`);
            });

            $('#prodi-container').removeClass('d-none');
            $('#prodi_id').prop('disabled', false);
        }
    });

    $('#prodi_id').on('change', function () {
        const prodiId = $(this).val();

        // Reset Kelas
        $('#kelas_id').html('<option value="">Pilih Kelas</option>').prop('disabled', true);
        $('#kelas-container').addClass('d-none');

        if (prodiId) {
            // Populate Kelas dropdown
            const prodi = jurusan.flatMap(j => j.prodis).find(p => p.id == prodiId);
            prodi.kelas.forEach(kelas => {
                $('#kelas_id').append(`<option value="${kelas.id}">${kelas.nama_kelas}</option>`);
            });

            $('#kelas-container').removeClass('d-none');
            $('#kelas_id').prop('disabled', false);
        }
    });

    // Chart Data
    const data = {
        labels: ['Sudah Upload Sertifikat', 'Belum Upload Sertifikat'],
        datasets: [{
            data: [
                {{ $data['uploaded'] }},
                {{ $data['not_uploaded'] }}
            ],
            backgroundColor: ['#4CAF50', '#F44336'],
            hoverOffset: 4
        }]
    };

    // Render Chart
    const ctx = document.getElementById('donutChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endsection
