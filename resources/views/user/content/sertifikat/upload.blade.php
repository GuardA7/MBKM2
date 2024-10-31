@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center text-primary fw-bold mb-4 mt-3">Upload Sertifikat</h2>
            <p class="text-center text-muted mb-4">Silahkan isi form di bawah ini untuk mengunggah sertifikat Anda dengan mudah.</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('sertifikat.store') }}" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm rounded bg-light" id="uploadForm">
                @csrf

                <!-- Nama Pelatihan -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control shadow-sm" id="nama_pelatihan" name="nama_pelatihan" placeholder="Nama Pelatihan" required>
                    <label for="nama_pelatihan">Nama Pelatihan</label>
                </div>

                <!-- Tanggal Berlaku -->
                <div class="form-floating mb-3">
                    <input type="date" class="form-control shadow-sm" id="tanggal_berlaku" name="tanggal_berlaku" required>
                    <label for="tanggal_berlaku">Tanggal Berlaku</label>
                </div>

                <!-- Tanggal Berakhir -->
                <div class="form-floating mb-3">
                    <input type="date" class="form-control shadow-sm" id="tanggal_berakhir" name="tanggal_berakhir" required>
                    <label for="tanggal_berakhir">Tanggal Berakhir</label>
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label for="sertifikat_file" class="form-label fw-bold">Upload Sertifikat</label>
                    <input class="form-control shadow-sm" type="file" id="sertifikat_file" name="sertifikat_file" required>
                    <small class="text-muted">Format file: PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                    <!-- Tempat untuk menampilkan pesan kesalahan -->
                    <div id="fileError" class="text-danger mt-2"></div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="button" class="btn btn-primary btn-lg rounded-pill shadow-sm" id="openModalBtn">
                        <i class="bi bi-cloud-upload-fill"></i> Upload Sertifikat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pengunggahan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin mengunggah sertifikat ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary" id="confirmUploadBtn">Ya, Upload</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap 5 JS (required for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript to handle modal, form validation, and form submission -->
<script>
    // Show modal when "Upload Sertifikat" button is clicked
    document.getElementById('openModalBtn').addEventListener('click', function() {
        var fileInput = document.getElementById('sertifikat_file');
        var fileError = document.getElementById('fileError');
        var allowedExtensions = /(\.pdf|\.jpg|\.jpeg|\.png)$/i;

        // Reset error message
        fileError.textContent = '';

        // Check if the file has a valid format
        if (!allowedExtensions.exec(fileInput.value)) {
            fileError.textContent = 'Format file tidak valid! Silahkan unggah file dengan format: PDF, JPG, JPEG, PNG.';
            fileInput.value = ''; // Clear the file input
            return false; // Prevent modal from showing
        }

        var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.show();
    });

    // Submit form when "Ya, Upload" button is clicked in modal
    document.getElementById('confirmUploadBtn').addEventListener('click', function() {
        document.getElementById('uploadForm').submit();
    });
</script>

@endsection
