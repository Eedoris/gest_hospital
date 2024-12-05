@extends('layouts/contentNavbarLayout')


@section('content')
    <h1>Statistiques</h1>
    <h2>Consultations par mois</h2>
    <table>
        <thead>
            <tr>
                <th>Mois</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultationsByMonth as $data)
                <tr>
                    <td>{{ $data->month }}</td>
                    <td>{{ $data->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
