@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

    <!-- Examples -->

    <!-- Content types -->
    <h5 class="pb-1 mb-6">Content types</h5>

    <h6 class="pb-1 mb-6 text-muted">Listes des patients</h6>
    <div class="row mb-12 g-6" id="search">
        @foreach ($patients as $patient)
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Patient
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">nom: {{ $patient->name }}</h5>
                        <h5 class="card-title">Prénoms: {{ $patient->surname }}</h5>
                        <a href="{{ route('consultations.index', $patient->uuid) }}" class="btn btn-primary">Voir
                            consultations</a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    </div>

    <script src="{{ asset('js/search.js') }}"></script>
@endsection
