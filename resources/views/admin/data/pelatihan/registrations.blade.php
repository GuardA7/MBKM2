@extends('admin.layouts.app')

@section('title', 'Registrasi Pelatihan')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Registrasi untuk Pelatihan: {{ $pelatihan->nama }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pelatihan.index') }}" class="text-decoration-none">Pelatihan</a></li>
            <li class="breadcrumb-item active">Registrasi</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Data Registrasi Pengguna
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="registrationsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Status Pendaftaran</th>
                            <th>Bukti Pembayaran</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <!-- Include Yajra DataTables JS and CSS -->
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/yajra-datatables/js/dataTables.yajra.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#registrationsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.pelatihan.getRegistrationsData', $pelatihan->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'user_email', name: 'user_email' },
                    {
                        data: 'status_pendaftaran',
                        name: 'status_pendaftaran',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <select class="form-control status-dropdown" data-id="${row.id}">
                                    <option value="menunggu" ${data === 'menunggu' ? 'selected' : ''}>Menunggu</option>
                                    <option value="diterima" ${data === 'diterima' ? 'selected' : ''}>Diterima</option>
                                    <option value="ditolak" ${data === 'ditolak' ? 'selected' : ''}>Ditolak</option>
                                </select>
                            `;
                        }
                    },
                    { data: 'bukti_pembayaran', name: 'bukti_pembayaran', orderable: false, searchable: false }
                ]
            });

            // Event listener untuk perubahan status pendaftaran dengan SweetAlert2
            $('#registrationsTable').on('change', '.status-dropdown', function() {
                var registrationId = $(this).data('id');
                var newStatus = $(this).val();
                var dropdown = $(this);

                // Tampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda ingin mengubah status pendaftaran ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, ubah status',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika konfirmasi, kirim AJAX untuk memperbarui status
                        $.ajax({
                            url: "{{ route('admin.pelatihan.updateStatus') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: registrationId,
                                status_pendaftaran: newStatus
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Status pendaftaran berhasil diperbarui.',
                                    'success'
                                );
                                table.ajax.reload(null, false); // Refresh tabel tanpa reload halaman
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Gagal memperbarui status.',
                                    'error'
                                );
                                table.ajax.reload(null, false); // Tetap reload data jika gagal
                            }
                        });
                    } else {
                        // Jika batal, kembalikan dropdown ke nilai semula
                        table.ajax.reload(null, false); // Reload table untuk mengembalikan nilai asli
                    }
                });
            });
        });
    </script>


@endpush
