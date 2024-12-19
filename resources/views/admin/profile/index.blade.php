@extends('admin.layouts.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Profile</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>

            <!-- Profile Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-user-circle"></i> Profile</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                @csrf

                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                           value="{{ $admin->nama }}" readonly>
                                </div>

                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="{{ $admin->email }}" readonly>
                                </div>

                                <!-- Update Button -->
                                <div class="d-flex justify-content-start">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
