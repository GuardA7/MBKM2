@extends('admin.layouts.app')

@section('title', 'Prodi')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Prodi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item">Prodi</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('tambah_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Tambah Berhasil!</strong> Prodi telah berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <a href="{{ route('admin.prodi.create') }}" class="btn btn-success mb-2 btn-sm"><i class="fas fa-plus"></i> Tambah
                Prodi</a>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Data Kelas
                </div>
                <div class="card-body">
                    <table id="prodiTable" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Prodi</th>
                                <th>ID Jurusan</th>
                                <th>Nama Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @push('script')
        <script>
            $(document).ready(function() {
                var table = $('#prodiTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.prodi.index') }}",
                        type: 'GET',
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'nama_prodi',
                            name: 'nama_prodi'
                        },
                        {
                            data: 'jurusan.id',
                            name: 'jurusan.id',
                            defaultContent: 'Tidak Ada'
                        },
                        {
                            data: 'nama_jurusan',
                            name: 'nama_jurusan',
                            defaultContent: 'Tidak Ada'
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `
            <a class="btn btn-primary btn-sm" href="{{ route('admin.prodi.edit', '') }}/${row.id}"><i class="fas fa-pen"></i></a>
            <form action="{{ route('admin.prodi.destroy', '') }}/${row.id}" method="POST" class="d-inline delete-form">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="button" class="btn btn-danger btn-sm delete-button" data-id="${row.id}"><i class="fas fa-trash"></i></button>
            </form>`;
                            }
                        }

                    ]
                });

                // Handle Delete button click
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
