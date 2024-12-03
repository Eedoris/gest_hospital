@extends('layouts/contentNavbarLayout')

@section('title', 'Consultations et Analyses du patient')

@section('content')
    <div class="container">
        <h3>Consultations et analyses du patient : {{ $patient->name }} {{ $patient->surname }}</h3>

        @if (session('success_ajout'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success_ajout') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <a href="{{ route('docpat') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-chevron-left"></i> Retour
        </a>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link @if (request()->get('fragment') == 'consultations' || !request()->has('fragment')) active @endif" href="?fragment=consultations">Ajouter
                    une
                    consultation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->get('fragment') == 'historique') active @endif"
                    href="?fragment=historique">Historique</a>
            </li>
        </ul>

        <div class="tab-content mt-4">

            <div class="tab-pane fade @if (request()->get('fragment') == 'consultations' || !request()->has('fragment')) show active @endif" id="consultations">
                @include('qoctor.add')
            </div>

            <div class="tab-pane fade @if (request()->get('fragment') == 'historique') show active @endif" id="historique">
                @include('qoctor.history')
            </div>
        </div>
    </div>
@endsection
