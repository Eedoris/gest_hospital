@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rendez-vous</h5> <small class="text-body float-end">Fiche</small>
                </div>
                <!-- Affichage des messages de session -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <form action= "{{ route('appointstore') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-fullname">Nom </label>
                            <input type="text" class="form-control" id="basic-default-fullname" name="name"
                                placeholder="nom..." />
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-company">Prenoms </label>
                            <input type="text" class="form-control" id="basic-default-company" name="surname"
                                placeholder="prenoms..." />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="date_rdv">Date </label>
                            <input type="date" class="form-control" id="date_rdv" name="date_app" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="id_serv">Sélectionner un service</label>
                            <select class="form-control" id="id_serv" name="service_id" required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id_serv }}">{{ $service->serv_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
