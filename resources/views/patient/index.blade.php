@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
    <div class="row g-6">

        <!-- Basic Buttons -->

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="demo-inline-spacing">
                        <!-- <button type="button" class="btn btn-primary">Ajouter un patient</button>-->
                        <a href="{{ route('createpatient') }}" class="btn btn-primary">
                            Ajouter un patient
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Bootstrap Table -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <h5 class="card-header">Patients</h5>
            <div class="table-responsive text-nowrap">
                <table class="table" id="data_list">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Date de naissance</th>
                            <th>Sexe</th>
                            <th>Adresse</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($patients as $patient)
                            <tr class="item">
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->surname }}</td>
                                <td>{{ $patient->date_of_birth }} </td>
                                <td>{{ $patient->sex }}</td>
                                <td>{{ $patient->adress }}</td>
                                <td>{{ $patient->contact }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('patientsedit', $patient->uuid) }}"><i
                                                    class="bx
                                                bx-edit-alt me-2"></i>
                                                Edit </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->

        <hr class="my-12">
        <div class="text">
          
        </div>
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
@endsection
