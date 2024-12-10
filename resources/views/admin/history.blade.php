@extends('layouts.contentNavbarLayout')

@section('title', 'Historique des consultations')

@section('content')
    <div class="container mt-4">
        <h3>Historique des consultations</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="data_list">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Docteur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($consultations as $consultation)
                        <tr>
                            <td>{{ $consultation->id_cons }}</td>
                            <td>{{ $consultation->date_cons }}</td>
                            <td>{{ $consultation->patient->name ?? 'N/A' }}
                                <span>{{ $consultation->patient->surname ?? 'N/A' }}
                            </td>
                            <td>{{ $consultation->doctor->name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune consultation trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
@endsection
