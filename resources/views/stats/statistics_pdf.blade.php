@extends('layouts/contentNavbarLayout')

@section('content')
    <h1>Statistiques</h1>
    <h2>Consultations par mois</h2>
    <table>
        <thead>
            <tr>
                <th>Mois</th>
                <th>Nombre de consultations</th>
                <th>Nouveaux patients</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultationsByMonth as $data)
                <tr>
                    <td>{{ $data->month }}</td>
                    <td>{{ $data->count }}</td>
                    <td>
                        {{-- Remplacez par les données de nouveaux patients --}}
                        {{ $newPatientsByMonth->firstWhere('month', $data->month)->count ?? 0 }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
