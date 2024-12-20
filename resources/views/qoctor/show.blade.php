@extends('layouts/contentNavbarLayout')

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .container,
        .container * {
            visibility: visible;
        }

        .container {
            position: absolute;
            left: 0;
            top: 0;
        }

        .btn,
        .navbar {
            display: none !important;
        }
    }
</style>

@section('title', 'Dossier du patient')

@section('content')

    <div class="container">
        <h2>Dossier du patient</h2>
        <div class="card mb-4">
            <div class="card-header">Informations personnelles</div>
            <div class="card-body">
                <p><strong>Nom :</strong> {{ $patient->name }}</p>
                <p><strong>Prénoms :</strong> {{ $patient->surname }}</p>
                <p><strong>Date de naissance :</strong>
                    {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') }} </>
                </p>
                <p><strong> Sexe : </strong> {{ $patient->sex }}</p>
                <p><strong>Contact :</strong> {{ $patient->contact }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Consultations</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Diagnostic</th>
                            <th>Symptômes</th>
                            <th>Analyses</th>
                            <th>Prescriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patient->consultations as $consultation)
                            <tr>
                                <td>{{ $consultation->date_cons }}</td>
                                <td>{{ $consultation->note }}</td>
                                <td>{{ $consultation->symptome }}</td>
                                <td>
                                    @forelse ($consultation->analyses as $analyse)
                                        <p>- {{ $analyse->libelle }} : {{ $analyse->result ?? 'N/A' }}</p>
                                    @empty
                                        <p>Aucune analyse effectuée.</p>
                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($consultation->prescriptions as $prescription)
                                        <p>- {{ $prescription->product }} ({{ $prescription->dosage }})</p>
                                    @empty
                                        <p>Aucune prescription.</p>
                                    @endforelse
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <button onclick="window.print()" class="btn btn-success">
                <i class="bx bx-printer me-2"></i> Imprimer le dossier
            </button>

            <a href="{{ route('docpat') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>

    </div>
@endsection
