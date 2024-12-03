@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Grafik Sertifikat</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Grafik</li>
        </ol>

        <div class="d-flex align-items-center mb-3">
            <!-- Filter Berdasarkan Role -->
            <label for="role" class="form-label me-2 mb-0">Filter Berdasarkan Role:</label>
            <select id="role" class="form-select form-select-sm me-3" style="width: auto;" onchange="filterChart()">
                <option value="all" {{ $selectedRole == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="mahasiswa" {{ $selectedRole == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="dosen" {{ $selectedRole == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="masyarakat" {{ $selectedRole == 'masyarakat' ? 'selected' : '' }}>Umum</option>
            </select>

            <!-- Filter Berdasarkan Tahun -->
            <label for="year" class="form-label me-2 mb-0">Filter Berdasarkan Tahun:</label>
            <select id="year" class="form-select form-select-sm" style="width: auto;" onchange="filterChart()">
                @foreach ($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="position: relative; height: 400px; width: 100%;">
                    <canvas id="sertifikatChart"></canvas>
                </div>
            </div>
        </div>

        <div style="position: relative; height: 400px; width: 100%;">
            <canvas id="sertifikatChart"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('sertifikatChart').getContext('2d');
            const data = @json($data); // Data sertifikat yang sesuai dengan role dan tahun yang dipilih

            const datasets = [];

            // Tambahkan dataset sesuai dengan role yang ada di data
            if (data.hasOwnProperty('mahasiswa')) {
                datasets.push({
                    label: 'Mahasiswa',
                    data: Object.values(data['mahasiswa']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                });
            }

            if (data.hasOwnProperty('dosen')) {
                datasets.push({
                    label: 'Dosen',
                    data: Object.values(data['dosen']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                });
            }

            if (data.hasOwnProperty('masyarakat')) {
                datasets.push({
                    label: 'Umum',
                    data: Object.values(data['masyarakat']),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                });
            }

            const sertifikatChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Sertifikat'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });

            function filterChart() {
                const selectedRole = document.getElementById('role').value;
                const selectedYear = document.getElementById('year').value;
                window.location.href = `{{ route('admin.grafik.index') }}?role=${selectedRole}&year=${selectedYear}`;
            }
        </script>
    </div>
@endsection
