@extends('layouts.app')

@section('content')

    <link href="{{ asset('lib/summernote/summernote-bs5.min.css') }}" rel="stylesheet">

    <div class="pagetitle">
        <h1>Servicios</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('servicios.index') }}">Servicios</a>/li>
                <li class="breadcrumb-item active">Editar Servicio</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card">

            <div class="card-body">

                <h5 class="card-title">Editar Servicio</h5>

                <form action="{{ route('servicios.update') }}" class="row g-3" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="servicio_id" value="{{ $servicios->id }}" />

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="Titulo" name="title" value="{{ $servicios->title }}">
                            <label>Titulo</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-control" name="section_id">
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" {{ $section->id == $servicios->section_id  ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Sección</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label>Descripción</label>
                        <textarea id="description" name="description" class="form-control" rows="10"> {{ $servicios->description }} </textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </form>

            </div>
        </div>

    </section>
@endsection

<script type="module" src="{{ asset('lib/summernote/summernote-bs5.min.js') }}"></script>
<script type="module" src="{{ asset('lib/summernote/lang/summernote-es-ES.min.js') }}"></script>
<script type="module">

    $(document).ready(function () {

        $(document).ready(function(){

            $('#description').summernote({

                placeholder: 'Crea el servicio...',
                lang: 'es-ES',
            });

        });
    });
</script>
