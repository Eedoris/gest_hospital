@extends('layouts/contentNavbarLayout')

@section('content')
    <!-- Basic Buttons -->
    <div class="row g-6">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="demo-inline-spacing">
                        <a href="{{ route('createappoint') }}" class="btn btn-primary"> Agencer un rendez-vous </a>
                    </div>
                </div>
            </div>
        </div>


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <h5 class="card-header">Rendez-vous</Rendez-vous></h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="data_list">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Contact</th>
                            <th>Date du rendez-vous</th>
                            <th>Heure</th>
                            <th>service</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($appoints as $appoint)
                            <tr class="item">
                                <td>{{ $appoint->name }}</td>
                                <td>{{ $appoint->surname }}</td>
                                <td>{{ $appoint->contact }} </td>
                                <td>{{ $appoint->date_app }} </td>
                                <td>{{ $appoint->time_app }}</td>
                                <td>{{ $appoint->service->serv_name }}</td>


                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('appoint.edit', ['token' => encrypt($appoint->id_appoint)]) }}">
                                                <i class="fa fa-edit"></i> Modifier
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <script src="{{ asset('js/search.js') }}"></script>
    @endsection
