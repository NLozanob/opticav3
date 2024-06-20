@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center bg-danger" style="background-image: url({{ asset('backend/dist/img/espacio.jpg') }}); height:575px">
    <section class="content">
        <div class="error-page mt-5">
            <h2 class="headline text-warning">403</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Acceso Prohibido.</h3>
                <p>
                    Lo siento, no tienes permisos para acceder a esta página.
                </p>
                <div class="d-flex justify-content-center mr-5">
                    <a href="{{ route('home') }}" class="btn btn-success">Regresar</a>
                </div>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
</div>
@endsection