@extends('layouts.contentNavbarLayout')

@section('title', 'Historique des consultations')

@section('content')
    <div class="container">
        <h3>Historique des consultations</h3>

        <form method="GET" action="{{ route('consultation.history') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="doctor_id">Filtrer par médecin</label>
                    <select id="doctor_id" name="doctor_id" class="form-control">
                        <option value="">Tous les médecins</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id_user }}"
                                {{ request('doctor_id') == $doctor->id_user ? 'selected' : '' }}>
                                {{ $doctor->name }} {{ $doctor->surname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="patient_id">Filtrer par patient</label>
                    <select id="patient_id" name="patient_id" class="form-control">
                        <option value="">Tous les patients</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id_pat }}"
                                {{ request('patient_id') == $patient->id_pat ? 'selected' : '' }}>
                                {{ $patient->name }} {{ $patient->surname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Note</th>
                    <th>Docteur</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($consultations as $consultation)
                    <tr>
                        <td>{{ $consultation->date_cons }}</td>
                        <td>{{ $consultation->patient->name }} {{ $consultation->patient->surname }}</td>
                        <td>{{ $consultation->note }}</td>
                        <td>{{ $doctor->name }} {{ $doctor->surname }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Aucune consultation trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
