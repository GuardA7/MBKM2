@extends('user.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Sertifikat yang Telah Diupload</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped" id="sertifikatTable">
        <thead>
            <tr>
                <th>Nama Pelatihan</th>
                <th>Tanggal Berlaku</th>
                <th>Tanggal Berakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

@section('scripts')
<script>
    $(function() {
        $('#sertifikatTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('certificates.data') }}',
            columns: [
                { data: 'nama_pelatihan', name: 'nama_pelatihan' },
                { data: 'tanggal_berlaku', name: 'tanggal_berlaku' },
                { data: 'tanggal_berakhir', name: 'tanggal_berakhir' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
@endsection
