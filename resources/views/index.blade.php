@extends('user.layouts.app')

@section('content')
    <main>
        <div class="hero-image position-relative">
            <img src="{{ asset('user/img/DSC_5537-1320x600.jpg') }}" alt="Hero Image" class="w-100">

        </div>
            </form>
            @include('user.content.pelatihan.list_pelatian')


    </main>
@endsection
