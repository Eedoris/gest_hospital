@extends('layouts/sreach')

@section('Statistiques')

@section('content')

    <div class="container">
        <h1 class="my-4 text-center">Statistiques</h1>
        <!--  <a href="{{ route('statistics.export') }}" class="btn btn-primary ">Exporter les statistiques</a>-->

        <hr>

        <div>
            <div class="d-flex justify-content-start">

                <a href="{{ route('statistics.export') }}" class="btn btn-primary ">Exporter les statistiques</a>

                {{-- <button type="submit" class="btn btn-primary">Exporter</button> --}}

                {{-- <form method="GET" action="{{ route('statistics.export') }}">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="start_date">Date de début :</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-5">
                            <label for="end_date" class="mt-2">Date de fin :</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Exporter</button>
                        </div>
                    </div>

                </form> --}}

            </div>
            <div class="d-flex justify-content-end">

                <form method="GET" action="{{ route('statistics.index') }}" class="md-1">
                    <select name="month" class="form-select">
                        <option value="">Tous les mois</option>
                        @foreach ($monthNames as $key => $name)
                            <option value="{{ $name }}" {{ request('month') === $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Filtrer</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <!-- Consultations par mois -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        Consultations par mois
                    </div>
                    <div class="card-body">
                        <canvas id="consultationsChart"></canvas>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p><strong>Total :</strong> {{ $consultationsByMonth->sum('count') }} consultations</p>
                    <p><strong>Mois avec le plus de consultations :</strong>
                        @php
                            $mostConsultedMonth = $consultationsByMonth->sortByDesc('count')->first();
                        @endphp

                        @if ($mostConsultedMonth)
                            {{ $mostConsultedMonth['month'] }}
                        @else
                            Aucune consultation trouvée
                        @endif
                    </p>

                </div>
            </div>


            <!-- Nouveaux patients -->
            <div class="col-md-6 mb-4">

                <div class="card">
                    <div class="card-header text-center">
                        Nouveaux patients par mois
                    </div>
                    <div class="card-body">
                        <canvas id="newPatientsChart"></canvas>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p><strong>Total pour {{ $selectedMonth ?? 'tous les mois' }} :</strong>
                        {{ $filteredPatients->sum('count') }} nouveaux patients</p>
                    <p><strong>Mois avec le plus de nouveaux patients :</strong>
                        @php

                            if (isset($selectedMonth) && $selectedMonth !== null) {
                                $mostPatientsMonth = $filteredPatients->sortByDesc('count')->first();
                            } else {
                                $mostPatientsMonth = $newPatients->sortByDesc('count')->first();
                            }
                        @endphp

                        @if ($mostPatientsMonth)
                            {{ $mostPatientsMonth['month'] }}
                        @else
                            Aucun mois avec des nouveaux patients trouvés
                        @endif
                    </p>


                </div>
            </div>


            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        Médicaments les plus prescrits
                    </div>
                    <div class="card-body">
                        <canvas id="medicationsChart"></canvas>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p><strong>Total de prescriptions :</strong> {{ $medications->sum('count') }}</p>
                    <p><strong>Médicament le plus prescrit :</strong>
                        {{ $medications->sortByDesc('count')->first()['product'] }}
                        ({{ $medications->sortByDesc('count')->first()['count'] }} prescriptions)
                    </p>
                </div>

            </div>


            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        Répartition des patients par sexe
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
                    </div>

                    <div class="text-center mt-3">
                        <p><strong>Homme :</strong>
                            {{ $genderStats->where('sex', 'Masculin')->first()['count'] ?? 0 }} patients</p>
                        <p><strong>Femme :</strong>
                            {{ $genderStats->where('sex', 'Féminin')->first()['count'] ?? 0 }} patients</p>
                    </div>

                </div>
            </div>

            <!-- Répartition des patients par tranche d'âge -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        Répartition des patients par tranche d'âge
                    </div>
                    <div class="card-body">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p><strong>0-17 ans :</strong>
                        {{ $ageStats->where('age_range', '0-17')->first()['count'] ?? 0 }} patients </p>
                    <p><strong>18-35 ans :</strong>
                        {{ $ageStats->where('age_range', '18-35')->first()['count'] ?? 0 }} patients</p>
                    <p><strong>36+ ans :</strong>
                        {{ $ageStats->where('age_range', '36+')->first()['count'] ?? 0 }} patients</p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const consultationsCtx = document.getElementById('consultationsChart').getContext('2d');

        const months = @json($consultationsByMonth->pluck('month'));
        const counts = @json($consultationsByMonth->pluck('count'));

        const dynamicColors = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)'
        ];
        const selectedColors = dynamicColors.slice(0, months.length);

        new Chart(consultationsCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Consultations',
                    data: counts,
                    backgroundColor: selectedColors,
                    borderColor: selectedColors.map(color => color.replace('0.5',
                        '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    },

                    y: {
                        beginAtZero: true,
                        max: 40,

                        title: {
                            display: true,
                            text: 'Nombre de consultations',

                        }

                    }
                }
            }
        });


        const newPatientsCtx = document.getElementById('newPatientsChart').getContext('2d');
        new Chart(newPatientsCtx, {
            type: 'line',
            data: {
                labels: @json($filteredPatients->pluck('month')),
                datasets: [{
                    label: 'Nouveaux Patients',
                    data: @json($filteredPatients->pluck('count')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        const medicationsCtx = document.getElementById('medicationsChart').getContext('2d');
        new Chart(medicationsCtx, {
            type: 'doughnut',
            data: {
                labels: @json($medications->pluck('product')),
                datasets: [{
                    label: 'Médicaments',
                    data: @json($medications->pluck('count')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });


        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: @json($genderStats->pluck('sex')),
                datasets: [{
                    label: 'Sexe',
                    data: @json($genderStats->pluck('count')),
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'polarArea',
            data: {
                labels: @json($ageStats->pluck('age_range')),
                datasets: [{
                    label: 'Tranche d\'âge',
                    data: @json($ageStats->pluck('count')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        suggestedMax: 20,
                        beginAtZero: true
                    }
                }

            }
        });
    </script>
@endsection
