@extends('layouts.app')

@section('content')

<div class="pagetitle">
    <h1>Servicios</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home.section', $servicios->section_id) }}">Section</a></li>
            <li class="breadcrumb-item active">Servicios</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">

    <div class="card"
        <div class="card-header">{{ $servicios->title }}</div>
        <div class="card-body">
            {!! $servicios->description !!}
        </div>
    </div>

</section>

@endsection
