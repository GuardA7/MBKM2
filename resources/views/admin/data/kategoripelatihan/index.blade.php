@extends('admin.layouts.app')

@section('title', 'Kategori Pelatihan')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kategori Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item">Kategori</li>
            </ol>

            @if (session('tambah_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Tambah Berhasil!</strong> Kategori telah berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <a href="{{ route('admin.kategori.create') }}" class="btn btn-success btn-sm mb-2"><i class="fas fa-plus"></i> Tambah
                Kategori</a>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i> Data Kategori Pelatihan
                    </div>
                    <div class="card-body">
                        <table id="kategoriTable" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kategori</th>
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
                // Data Table
                var table = $('#kategoriTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.kategori.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.kategori.edit', '') }}/${row.id}"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('admin.kategori.destroy', '') }}/${row.id}" method="POST" class="d-inline delete-form">
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
                        text: "Hapus kategori ini? ID=" + deleteId,
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
                                        false); // Reload DataTable tanpa mengatur ulang paging
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
