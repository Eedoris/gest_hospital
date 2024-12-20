@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

    <!-- Examples -->

    <h6 class="pb-1 mb-6 text-muted">Listes des patients</h6>
    <div class="row mb-12 g-6" id="search">
        @foreach ($patients as $patient)
            <div class="col-md-6 col-lg-4 card-container">
                <div class="card">
                    <div class="card-header">
                        Patient
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">nom: {{ $patient->name }}</h5>
                        <h5 class="card-title">Prénoms: {{ $patient->surname }}</h5>
                        <a href="{{ route('consultations.index', $patient->uuid) }}" class="btn btn-primary">Voir
                            consultations</a>

                        <!-- Dropdown avec option Imprimer -->
                        <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('patients.show', $patient->uuid) }}">
                                    <i class="fa fa-times-circle"></i> Imprimer
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <script>
        document.getElementById('global_search').addEventListener('input', function() {
            filterCards('search', 'global_search'); // 'search' correspond à l'ID contenant toutes les cartes
        });

        function filterCards(containerId, searchInputId) {
            let query = document.getElementById(searchInputId).value.toLowerCase();
            let cards = document.querySelectorAll(`#${containerId} .card-container`);

            cards.forEach(card => {
                let cardText = card.textContent.toLowerCase();
                card.style.display = cardText.includes(query) ? '' : 'none';
            });
        }
    </script>

    {{-- <script>
        document.getElementById('global_search').addEventListener('input', function() {
            filterTable('data_list', 'global_search');
        });

        function filterTable(containerId, searchInputId) {
            let query = document.getElementById(searchInputId).value.toLowerCase();
            let rows = document.querySelectorAll(`#${containerId} tr`);

            rows.forEach(row => {
                let rowText = Array.from(row.querySelectorAll('td')).map(cell => cell.textContent.toLowerCase())
                    .join(' ');
                row.style.display = rowText.includes(query) ? '' : 'none';
            });
        }
    </script> --}}


@endsection
