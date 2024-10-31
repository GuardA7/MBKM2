@extends('user.layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>

    <div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="h5">List Sertifikat Anda</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive"> <!-- Menambahkan div responsif -->
                <table id="sertifikat-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelatihan</th>
                            <th>Tanggal Berlaku</th>
                            <th>Tanggal Berakhir</th>
                            <th>Download</th> <!-- Kolom untuk Download -->
                            <th>Hapus</th>    <!-- Kolom untuk Hapus -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- jQuery and Bootstrap Bundle -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables and Bootstrap 4 integration -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#sertifikat-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('sertifikat.data') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama_pelatihan', name: 'nama_pelatihan' },
            { data: 'tanggal_berlaku', name: 'tanggal_berlaku' },
            { data: 'tanggal_berakhir', name: 'tanggal_berakhir' },
            {
                data: 'action_download',
                name: 'action_download',
                orderable: false,
                searchable: false
            },
            {
                data: 'action_delete',
                name: 'action_delete',
                orderable: false,
                searchable: false
            }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari Sertifikat..."
        }
    });

    // Fungsi hapus
// Update the hapus function to include the URL for deletion
function hapus(id) {
    var url = '{{ route('sertifikat.destroy', ':id') }}'; // Placeholder for the route
    url = url.replace(':id', id); // Replace with the actual ID

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Tetap Hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "DELETE",
                success: function(data) {
                    table.ajax.reload();
                    Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);  // Log the error response
                    Swal.fire('Gagal!', xhr.responseJSON.message || 'Terjadi kesalahan saat menghapus data.', 'error');
                }
            });
        }
    });
}
    // Event listener untuk tombol hapus
    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        hapus(id);
    });
});
</script>

</body>
</html>
@endsection
