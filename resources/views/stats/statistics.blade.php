@extends('layouts/contentNavbarLayout')

@section('Statistiques')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Statistiques</h1>

        <div>
            <a href="{{ route('statistics.export') }}" class="btn btn-primary">Exporter les statistiques</a>

        </div>

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
            </div>

            <!-- Médicaments les plus prescrits -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        Médicaments les plus prescrits
                    </div>
                    <div class="card-body">
                        <canvas id="medicationsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Répartition des patients par sexe -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        Répartition des patients par sexe
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Consultations par mois
        const consultationsCtx = document.getElementById('consultationsChart').getContext('2d');
        new Chart(consultationsCtx, {
            type: 'bar',
            data: {
                labels: @json($consultationsByMonth->pluck('month')),
                datasets: [{
                    label: 'Consultations',
                    data: @json($consultationsByMonth->pluck('count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Nouveaux patients par mois
        const newPatientsCtx = document.getElementById('newPatientsChart').getContext('2d');
        new Chart(newPatientsCtx, {
            type: 'line',
            data: {
                labels: @json($newPatients->pluck('month')),
                datasets: [{
                    label: 'Nouveaux Patients',
                    data: @json($newPatients->pluck('count')),
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
                        beginAtZero: true
                    }
                }
            }
        });

        // Médicaments les plus prescrits
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

        // Répartition des patients par sexe
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

        // Répartition des patients par tranche d'âge
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
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
