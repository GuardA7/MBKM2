@extends('admin.layouts.app')

@section('title', 'Halaman Detail Sertifikat')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Sertifikat Pengguna</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.sertifikat.index') }}"
                    class="text-decoration-none">Sertifikat</a></li>
            <li class="breadcrumb-item active">Sertifikat Pengguna</li>
        </ol>

        @if (session('tambah_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Tambah Berhasil!</strong> Sertifikat telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <a href="{{ route('admin.sertifikat.create', ['userId' => $user->id]) }}" class="btn btn-success btn-sm mb-2">
            <i class="fas fa-plus"></i> Tambah Sertifikat
        </a>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Data Sertifikat untuk User ID {{ $userId }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userCertificatesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-start">ID</th>
                                <th class="text-start">Nomor Sertifikat</th>
                                <th class="text-start">Nama Pelatihan</th>
                                <th class="text-start">Tanggal Berlaku</th>
                                <th class="text-start">Tanggal Berakhir</th>
                                <th class="text-start">File Sertifikat</th>
                                <th class="text-start">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                var table = $('#userCertificatesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.sertifikat.detail', $userId) }}",
                        type: 'GET'
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            className: 'text-center'
                        },
                        {
                            data: 'no_sertifikat',
                            name: 'no_sertifikat',
                            className: 'text-start'
                        },
                        {
                            data: 'nama_pelatihan',
                            name: 'nama_pelatihan',
                            className: 'text-start'
                        },
                        {
                            data: 'tanggal_berlaku',
                            name: 'tanggal_berlaku',
                            className: 'text-start'
                        },
                        {
                            data: 'tanggal_berakhir',
                            name: 'tanggal_berakhir',
                            className: 'text-start'
                        },
                        {
                            data: 'sertifikat_file',
                            name: 'sertifikat_file',
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data) {
                                return `<a href="{{ url('') }}/${data}" target="_blank" class="btn btn-success btn-sm text-white"><i class="fas fa-eye" style="color: white;"></i> Lihat</a>`;
                            }

                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ]
                });

                $(document).on('click', '.delete-button', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    var deleteId = $(this).data('id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Hapus sertifikat dengan ID = " + deleteId + "?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Terhapus!', response.message, 'success');

                                        // Hapus sertifikat dari DataTable hanya di halaman detail
                                        var row = table.row($('#deleteButton' + deleteId)
                                            .parents('tr'));
                                        row.remove().draw();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
