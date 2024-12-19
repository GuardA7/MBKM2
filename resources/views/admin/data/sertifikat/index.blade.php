@extends('admin.layouts.app')

@section('title', 'Halaman Sertifikat')

@section('content')

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Sertifikat</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Sertifikat</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Data Sertifikat
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <label for="roleFilter" class="form-label me-2">Role:</label>
                        <select id="roleFilter" class="form-select">
                            <option value="">Semua</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table id="sertifikatTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="test-start">ID User</th>
                                    <th class="test-start">Nama</th>
                                    <th class="test-start">Role</th>
                                    <th class="test-start">Sertifikat</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script')
        <script>
            $(document).ready(function() {
                var table = $('#sertifikatTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.sertifikat.index') }}",
                        data: function(d) {
                            d.user_id =
                            "{{ auth()->id() }}"; 
                            d.role = $('#roleFilter').val(); // Kirimkan filter role jika ada
                        }
                    },
                    responsive: true,
                    columns: [{
                            data: 'user.id',
                            name: 'user.id',
                            className: 'text-start'
                        },
                        {
                            data: 'user.nama',
                            name: 'user.nama',
                            className: 'text-start'
                        },
                        {
                            data: 'user.role',
                            name: 'user.role',
                            className: 'text-start'
                        },
                        {
                            data: 'sertifikat',
                            name: 'sertifikat',
                            orderable: false,
                            searchable: false,
                            className: 'text-start'
                        }
                    ]
                });

                $('#roleFilter').on('change', function() {
                    table.ajax.reload(); // Memuat ulang DataTable sesuai dengan filter role
                });
            });
        </script>
    @endpush

@endsection