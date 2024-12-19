@extends('admin.layouts.app')

@section('title', 'Halaman Lsit Akun Dosen')

@section('content')

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Dosen</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Dosen</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Data Dosen
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-start">ID</th>
                                <th class="text-start">Nama</th>
                                <th class="text-start">NIDN</th>
                                <th class="text-start">Jurusan</th>
                                <th class="text-start">No. HP</th>
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
        $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.dosen.index') }}",
            responsive: true,
            columns: [
                { data: 'id', name: 'id', className: 'text-start' },
                { data: 'nama', name: 'nama', className: 'text-start' },
                { data: 'nidn', name: 'nidn', className: 'text-start' },
                { data: 'nama_jurusan', name: 'nama_jurusan', className: 'text-start' },
                { data: 'no_hp', name: 'no_hp', className: 'text-start' },
            ]
        });
    });
</script>
@endpush

@endsection
