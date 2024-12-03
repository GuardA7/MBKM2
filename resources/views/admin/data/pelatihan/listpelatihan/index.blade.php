@extends('admin.layouts.app')

@section('title', 'Pelatihan')

@section('content')

    <style>
        /* Limit the width of the Deskripsi column */
        .table th.text-nowrap,
        .table td.text-nowrap {
            white-space: nowrap;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table td.deskripsi {
            max-width: 100px;
            min-width: 80px;
        }
    </style>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Pelatihan</li>
            </ol>

            @if (session('tambah_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Tambah Berhasil!</strong> Pelatihan telah berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-success btn-sm mb-2">
                <i class="fas fa-plus"></i> Tambah Pelatihan
            </a>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Data Pelatihan
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table id="pelatihanTable" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-start">ID</th>
                                    <th class="text-start">Gambar</th>
                                    <th class="text-start">Nama Pelatihan</th>
                                    <th class="text-start">Jenis Pelatihan</th>
                                    <th class="text-start text-nowrap">Deskripsi</th>
                                    <th class="text-start">Mulai Pendaftaran</th>
                                    <th class="text-start">Berakhir Pendaftaran</th>
                                    <th class="text-start">Harga</th>
                                    <th class="text-start">Kuota</th>
                                    <th class="text-start">LSP</th>
                                    <th class="text-start">Kategori</th>
                                    <th class="text-start">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script')
        <script>
            $(document).ready(function() {
                var table = $('#pelatihanTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.pelatihan.index') }}",
                    responsive: true,
                    columns: [{
                            data: 'id',
                            name: 'id',
                            className: 'text-start'
                        },
                        {
                            data: 'gambar',
                            name: 'gambar',
                            className: 'text-start',
                            render: function(data) {
                                return data ?
                                    `<img src="{{ asset('img/pelatihan/') }}/${data}" alt="profile" style="max-width: 50px; max-height: 50px;">` :
                                    'No Image';
                            },
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'text-start'
                        },
                        {
                            data: 'jenis_pelatihan',
                            name: 'jenis_pelatihan',
                            className: 'text-start'
                        },
                        {
                            data: 'deskripsi',
                            name: 'deskripsi',
                            className: 'deskripsi text-start',
                            render: function(data) {
                                return data.length > 30 ? data.substring(0, 30) + '...' : data;
                            }
                        },
                        {
                            data: 'tanggal_pendaftaran',
                            name: 'tanggal_pendaftaran',
                            className: 'text-start'
                        },
                        {
                            data: 'berakhir_pendaftaran',
                            name: 'berakhir_pendaftaran',
                            className: 'text-start'
                        },
                        {
                            data: 'harga',
                            name: 'harga',
                            className: 'text-start'
                        },
                        {
                            data: 'kuota',
                            name: 'kuota',
                            className: 'text-start'
                        },
                        {
                            data: 'kategori.nama',
                            name: 'kategori.nama',
                            className: 'text-start'
                        },
                        {
                            data: 'lsp.nama',
                            name: 'lsp.nama',
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

                $(document).on('click', '.delete-button', function(e) {
                    e.preventDefault();
                    var deleteId = $(this).data('id');
                    var url = "{{ route('admin.pelatihan.destroy', '') }}/" + deleteId;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Hapus pelatihan ini? ID=" + deleteId,
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
                                    Swal.fire('Terhapus!', response.message, 'success');
                                    table.ajax.reload(null, false);
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
