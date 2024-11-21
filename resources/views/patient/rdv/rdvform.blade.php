@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form</h5> <small class="text-body float-end">Fiche patient</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('appoint.update') }}" method="POST">

                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label" for="name">Nom</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $appoint->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="surname">Prénom</label>
                            <input type="text" class="form-control" id="surname" name="surname"
                                value="{{ $appoint->surname }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="date_app">Date de rendez-vous</label>
                            <input type="date" class="form-control" id="date_app" name="date_app"
                                value="{{ $appoint->date_app }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="service_id">Sélectionner un service</label>
                            <select class="form-control" id="service_id" name="service_id" required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id_serv }}"
                                        {{ $appoint->service_id == $service->id_serv ? 'selected' : '' }}>
                                        {{ $service->serv_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
