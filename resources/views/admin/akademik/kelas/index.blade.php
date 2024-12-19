@extends('admin.layouts.app')

@section('title', 'Halaman List Kelas')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kelas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Kelas</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('tambah_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Tambah Berhasil!</strong> Kelas telah berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- button create -->
            <a href="{{ route('admin.kelas.create') }}" class="btn btn-success mb-2 btn-sm">
                <i class="fas fa-plus"></i> Tambah Kelas
            </a>

            <!-- Tabel Kelas start -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Data Kelas
                </div>
                <div class="card-body">
                    <table id="kelasTable" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">ID Kelas</th>
                                <th class="text-start">Nama Kelas</th>
                                <th class="text-start">Nama Prodi</th>
                                <th class="text-start">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                    <!-- Loading State -->
                    <div id="spinner" style="display: none;">Loading...</div>

                </div>
            </div>
            <!-- tabel kelas end -->

        </div>
    </main>

    <!-- script -->
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
                var table = $('#kelasTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.kelas.index') }}",
                        type: "GET",
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            className: 'text-start'
                        },
                        {
                            data: 'nama_kelas',
                            name: 'nama_kelas',
                            className: 'text-start'

                        },
                        {
                            data: 'nama_prodi',
                            name: 'nama_prodi',
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
                        text: "Hapus Kelas ini? ID=" + deleteId,
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
