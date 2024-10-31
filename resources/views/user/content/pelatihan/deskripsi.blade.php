@extends('user.layouts.app')

@section('content')
    <div class="container my-5">
        <h4 class="text-primary">Detail Pelatihan</h4>
        <div class="row">
            <div class="col-md-4">
                <img src="https://storage.googleapis.com/a1aa/image/t9yeRyh5wcWlcSruD9HLDHuI7U0Rzbe1df3m3EgDrMjUHBXnA.jpg"
                     alt="Illustration of people in a digital marketing training session"
                     class="img-fluid rounded mb-3" />

                <a href="/DaftarPelatihan" class="btn btn-primary w-100 mt-3">Daftar Pelatihan</a>
            </div>

            <div class="col-md-8">
                <h3>Pelatihan Digital Marketing</h3>
                <div class="alert alert-secondary price-tag py-2 mb-3">
                    Rp. 1.000.000,-
                </div>

                <p><strong>Lembaga Pelatihan</strong><br>Politeknik Negeri Indramayu</p>
                <p><strong>Instruktur</strong><br>Lintang Septiari</p>
                <p><strong>Sisa Kuota</strong><br>10 / 100</p>
            </div>
        </div>

        <div class="card mt-4 description-card">
            <div class="card-header bg-light fw-bold">
                Deskripsi
            </div>
            <div class="card-body">
                <p>Pelatihan Digital Marketing adalah program pelatihan yang dirancang untuk memberikan keterampilan dan pengetahuan
                   seputar pemasaran digital. Fokus utama dari pelatihan ini adalah memanfaatkan berbagai platform online untuk
                   mempromosikan produk atau layanan, seperti media sosial, mesin pencari, email marketing, dan konten digital lainnya.
                </p>
            </div>
        </div>
    </div>
@endsection
