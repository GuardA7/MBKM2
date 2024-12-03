@extends('admin.layouts.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Prodi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Prodi</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('tambah_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Tambah Berhasil!</strong> Prodi telah berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <a href="{{ route('admin.prodi.create') }}" class="btn btn-success mb-2 btn-sm">
                <i class="fas fa-plus"></i> Tambah Prodi
            </a>

            <!-- Tabel Jurusan -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Data Prodi
                </div>
                <div class="card-body">
                    <table id="prodiTable" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">ID Prodi</th>
                                <th class="text-start">Nama Prodi</th>
                                <th class="text-start">ID Jurusan</th>
                                <th class="text-start">Nama Jurusan</th>
                                <th class="text-start">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Spinner for Loading State -->
                    <div id="spinner" style="display: none;">Loading...</div>
                </div>
            </div>

        </div>
    </main>

    @push('script')
        <script>
            $(document).ready(function() {

                // csrf token 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Loading spinner for AJAX requests
                $(document).ajaxStart(function() {
                    $('#spinner').show();
                }).ajaxStop(function() {
                    $('#spinner').hide();
                });

                // DataTables AJAX setup
                var table = $('#prodiTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.prodi.index') }}",
                        type: "GET",
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            className: 'text-start'
                        },
                        {
                            data: 'nama_prodi',
                            name: 'nama_prodi',
                            className: 'text-start'

                        },
                        {
                            data: 'jurusan.id',
                            name: 'jurusan.id',
                            defaultContent: 'Tidak Ada',
                            className: 'text-start'

                        },
                        {
                            data: 'nama_jurusan',
                            name: 'nama_jurusan',
                            defaultContent: 'Tidak Ada',
                            className: 'text-start'

                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-start'
                        },
                    ]
                });

                // alert delete
                $(document).on('click', '.delete-button', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    var deleteId = $(this).data('id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Hapus Prodi ini? ID=" + deleteId,
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
                                        table.ajax.reload(null,
                                            false
                                        ); // Reload DataTable without resetting pagination
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
