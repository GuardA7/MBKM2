@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Users</h1>
    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>NIM</th>
                <th>NIDN</th>
                <th>NIK</th>
                <th>No HP</th>
                <th>Jenis Kelamin</th>
                <th>Prodi</th>
                <th>Kelas</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
<script>
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('users.data') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'nim', name: 'nim' },
                { data: 'nidn', name: 'nidn' },
                { data: 'nik', name: 'nik' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                { data: 'prodi', name: 'prodi', orderable: false, searchable: false },
                { data: 'kelas', name: 'kelas', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush

@endsection
