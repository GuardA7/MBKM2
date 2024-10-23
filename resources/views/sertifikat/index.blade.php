@extends('user.layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body>

<div class="container">
    <h1>Sertifikat List</h1>
    <table id="sertifikat-table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelatihan</th>
                <th>Tanggal Berlaku</th>
                <th>Tanggal Berakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sertifikat-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('sertifikat.data') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama_pelatihan', name: 'nama_pelatihan' },
                { data: 'tanggal_berlaku', name: 'tanggal_berlaku' },
                { data: 'tanggal_berakhir', name: 'tanggal_berakhir' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>

</body>
</html>
@endsection
