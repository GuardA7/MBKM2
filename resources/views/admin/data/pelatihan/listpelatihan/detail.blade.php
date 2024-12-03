@extends('admin.layouts.app')

@section('title', 'Detail Pelatihan')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Detail Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pelatihan.index') }}"
                        class="text-decoration-none">Pelatihan</a></li>
                <li class="breadcrumb-item">Detail</li>
            </ol>

            <div class="card shadow mb-4 border-0">
                <div class="card-header bg-secondary text-white d-flex align-items-center rounded-top">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>Detail Pelatihan</span>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Left Side: Image -->
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('img/pelatihan/gambar/' . $pelatihan->gambar) }}" alt="Gambar Pelatihan"
                                class="img-fluid shadow-sm rounded" style="max-height: 400px; object-fit: cover;">
                        </div>

                        <div class="col-md-6">
                            <h3 class="mb-3 text-dark"><strong>{{ $pelatihan->nama }}</strong></h3>
                            <p><i class="fas fa-building me-2"></i><strong>LSP:</strong> {{ $pelatihan->lsp->nama }}</p>
                            <p><i class="fas fa-tags me-2"></i><strong>Kategori:</strong> {{ $pelatihan->kategori->nama }}
                            </p>
                            <p><i class="fas fa-list-alt me-2"></i><strong>Jenis Pelatihan:</strong>
                                {{ $pelatihan->jenis_pelatihan }}</p>

                            <div class="mb-3">
                                <p class="mb-1"><strong>Deskripsi:</strong></p>
                                <p id="desc-preview">
                                    {{ \Illuminate\Support\Str::limit($pelatihan->deskripsi, 200) }}
                                    @if (strlen($pelatihan->deskripsi) > 200)
                                        <a href="javascript:void(0);" id="toggleDesc"
                                            class="text-primary text-decoration-underline">Read More</a>
                                    @endif
                                </p>
                                <p id="desc-full" class="d-none">
                                    {{ $pelatihan->deskripsi }}
                                    <a href="javascript:void(0);" id="toggleLess"
                                        class="text-primary text-decoration-underline">Show Less</a>
                                </p>
                            </div>

                            <div class="mb-3">
                                <p class="text-success fs-5"><strong>Harga:</strong> Rp.
                                    {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                            </div>

                            <p><i class="fas fa-users me-2"></i><strong>Kuota:</strong> {{ $pelatihan->kuota }}</p>
                            <p><i class="fas fa-calendar-alt me-2"></i><strong>Periode Pendaftaran:</strong>
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_pendaftaran)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($pelatihan->berakhir_pendaftaran)->format('d/m/Y') }}</p>

                            <button id="loadParticipants" class="btn btn-primary btn-lg mt-3 shadow-sm btn-sm">Lihat
                                Peserta</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4" id="participantsCard" style="display:none;">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i> Peserta Pelatihan
                </div>
                <div class="card-body">
                    <div id="spinner" style="display:none;" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="user" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>Pelatihan</th>
                                    <th>Status Pendaftaran</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Tanggal Pendaftaran</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </main>

@endsection

@section('styles')
    <style>
        .breadcrumb {
            background: #f8f9fa;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #0056b3);
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #007bff);
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection

@section('scripts')
    @push('script')
        <script>
            $(document).ready(function() {
                // Toggle deskripsi panjang/pendek
                $('#toggleDesc').click(function(e) {
                    e.preventDefault();
                    $('#desc-preview').hide();
                    $('#desc-full').show();
                });

                $('#toggleLess').click(function(e) {
                    e.preventDefault();
                    $('#desc-full').hide();
                    $('#desc-preview').show();
                });

                // Spinner loading untuk Ajax
                $(document).ajaxStart(function() {
                    $('#spinner').show();
                }).ajaxStop(function() {
                    $('#spinner').hide();
                });

                let table;
                $('#loadParticipants').click(function() {
                    console.log('Tombol Lihat Peserta diklik.');
                    console.log('Menginisialisasi DataTables...');
                    const pelatihanId = {{ $pelatihan->id }};

                    if ($.fn.dataTable.isDataTable('#user')) {
                        table.ajax.reload(null, false); // Reload jika tabel sudah ada
                    } else {
                        table = $('#user').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: '{{ route('admin.pelatihan.participants', $pelatihan->id) }}',
                                type: 'GET',
                            },
                            columns: [{
                                    data: 'nama_user',
                                    name: 'nama_user',
                                    title: 'Nama User'
                                },
                                {
                                    data: 'email_user',
                                    name: 'email_user',
                                    title: 'Email'
                                },
                                {
                                    data: 'nama_pelatihan',
                                    name: 'nama_pelatihan',
                                    title: 'Pelatihan'
                                },
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
                                {
                                    data: 'bukti_pembayaran',
                                    name: 'bukti_pembayaran',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'created_at',
                                    name: 'created_at',
                                    title: 'Tanggal Pendaftaran'
                                },
                            ]
                        });
                    }
                    $('#participantsCard').show();
                });

                $('#user').on('change', '.status-dropdown', function() {
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
                                    table.ajax.reload(null,
                                        false
                                    ); // Refresh the table without reloading the page
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr
                                        .responseText
                                    ); // Log the error response for debugging
                                    Swal.fire(
                                        'Gagal!',
                                        'Gagal memperbarui status.',
                                        'error'
                                    );
                                    table.ajax.reload(null,
                                        false
                                    ); // Refresh the table even if the update fails
                                }
                            });

                        } else {
                            // Jika batal, kembalikan dropdown ke nilai semula
                            table.ajax.reload(null,
                                false); // Reload table untuk mengembalikan nilai asli
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
