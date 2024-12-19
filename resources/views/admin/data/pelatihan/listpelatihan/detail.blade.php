@extends('admin.layouts.app')

@section('title', 'Halaman Detail Pelatihan')

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

                            <p><i class="fas fa-calendar-alt me-2"></i><strong>Periode Pelatihan:</strong>
                                {{ \Carbon\Carbon::parse($pelatihan->jadwal_pelatihan_mulai)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($pelatihan->jadwal_pelatihan_selesai)->format('d/m/Y') }}</p>

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
                                    <th>Status kelulusan</th>
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
                    $('#desc-preview').addClass('d-none');
                    $('#desc-full').removeClass('d-none');
                });

                $('#toggleLess').click(function(e) {
                    e.preventDefault();
                    $('#desc-full').addClass('d-none');
                    $('#desc-preview').removeClass('d-none');
                });

                let table;
                $('#loadParticipants').click(function() {
                    console.log('Tombol Lihat Peserta diklik.');
                    console.log('Menginisialisasi DataTables...');
                    const pelatihanId = {{ $pelatihan->id }};

                    if ($.fn.dataTable.isDataTable('#user')) {
                        table.ajax.reload(null, false);
                    } else {
                        $('#user').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: '{{ route('admin.pelatihan.participants', $pelatihan->id) }}',
                                type: 'GET',
                            },
                            columns: [{
                                    data: 'nama_user',
                                    name: 'nama_user'
                                },
                                {
                                    data: 'email_user',
                                    name: 'email_user'
                                },
                                {
                                    data: 'nama_pelatihan',
                                    name: 'nama_pelatihan'
                                },
                                {
                                    data: 'status_pendaftaran',
                                    name: 'status_pendaftaran',
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
                                    data: 'status_kelulusan',
                                    name: 'status_kelulusan',
                                    render: function(data, type, row) {
                                    return `
                                            <select class="form-control status-dropdown" data-id="${row.id}">
                                                <option value="menunggu" ${data === 'menunggu' ? 'selected' : ''}>Menunggu</option>
                                                <option value="lulus" ${data === 'lulus' ? 'selected' : ''}>Lulus</option>
                                                <option value="tidak_lulus" ${data === 'tidak_lulus' ? 'selected' : ''}>Tidak Lulus</option>
                                            </select>
                                        `;
                                    }
                                },
                                {
                                    data: 'bukti_pembayaran',
                                    name: 'bukti_pembayaran'
                                },
                                {
                                    data: 'created_at',
                                    name: 'created_at'
                                },
                            ]
                        });

                    }
                    $('#participantsCard').show();
                });

                $('#user').on('change', '.status-dropdown', function() {
                    var registrationId = $(this).data('id');
                    var dropdownType = $(this).closest('td').index();
                    var newStatus = $(this).val();
                    var dropdown = $(this);

                    var statusType, statusText, routeUrl;

                    if (dropdownType === 3) { // Kolom status_pendaftaran
                        statusType = 'status_pendaftaran';
                        statusText = 'pendaftaran';
                        routeUrl = "{{ route('admin.pelatihan.updateStatus') }}";
                    } else if (dropdownType === 4) { // Kolom status_kelulusan
                        statusType = 'status_kelulusan';
                        statusText = 'kelulusan';
                        routeUrl = "{{ route('admin.pelatihan.updateStatusKelulusan') }}";
                    } else {
                        console.error('Dropdown type tidak dikenali.');
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda ingin mengubah status ${statusText} ini menjadi ${newStatus}.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, ubah status',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: routeUrl,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: registrationId,
                                    [statusType]: newStatus
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Berhasil!',
                                        `Status ${statusText} berhasil diperbarui menjadi ${newStatus}.`,
                                        'success'
                                    );
                                    table.ajax.reload(null, false);
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                    Swal.fire(
                                        'Gagal!',
                                        `Gagal memperbarui status ${statusText}.`,
                                        'error'
                                    );
                                    table.ajax.reload(null, false);
                                }
                            });
                        } else {
                            table.ajax.reload(null, false);
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
