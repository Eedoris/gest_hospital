@extends('layouts.contentNavbarLayout')

@section('title', 'Gestion des Médecins')

@section('content')
    <div class="container">

        <h3>Gestion des Médecins</h3>

        <!-- Formulaire d'ajout -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
            Ajouter un Médecin
        </button>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <!-- Tableau des Médecins -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Spécialité</th>
                    <th>Service</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->user->name }} {{ $doctor->user->surname }}</td>
                        <td>{{ $doctor->speciality->title ?? 'Non spécifiée' }}</td>
                        <td>{{ $doctor->service->serv_name }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#editDoctorModal-{{ $doctor->id_doctor }}">
                                        Modifier
                                    </a>

                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#deleteDoctorModal-{{ $doctor->id_doctor }}">
                                        Supprimer
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>


                    <div class="modal fade" id="editDoctorModal-{{ $doctor->id_doctor }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('doctor.update', $doctor->id_doctor) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Médecin</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Médecin -->
                                        <div class="mb-3">
                                            <label for="user_id">Médecin</label>
                                            <select name="user_id" class="form-control" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id_user }}"
                                                        {{ $user->id_user == $doctor->user_id ? 'selected' : '' }}>
                                                        {{ $user->name }} {{ $user->surname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Titre -->
                                        <div class="mb-3">
                                            <label for="doctor_title">Titre</label>
                                            <input type="text" class="form-control" name="doctor_title"
                                                value="{{ $doctor->doctor_title }}" required>
                                        </div>

                                        <!-- Spécialité -->
                                        <div class="mb-3">
                                            <label for="id_spe">Spécialité</label>
                                            <select name="id_spe" class="form-control" required>
                                                @foreach ($specialities as $speciality)
                                                    <option value="{{ $speciality->id_spe }}"
                                                        {{ $speciality->id_spe == $doctor->id_spe ? 'selected' : '' }}>
                                                        {{ $speciality->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Service -->
                                        <div class="mb-3">
                                            <label for="service_id">Service</label>
                                            <select name="service_id" class="form-control" required>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id_serv }}"
                                                        {{ $service->id_serv == $doctor->id_serv ? 'selected' : '' }}>
                                                        {{ $service->serv_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="deleteDoctorModal-{{ $doctor->id_doctor }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer Médecin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer ce médecin ?
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>


        <div class="modal fade" id="addDoctorModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('doctor.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Ajouter Médecin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="user_id">Médecin</label>
                                <select name="user_id" class="form-control" required>
                                    @foreach ($users as $user)
                                        @if ($user->statut == 'medecin')
                                            <option value="{{ $user->id_user }}">{{ $user->name }}
                                                {{ $user->surname }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="doctor_title">Titre</label>
                                <input type="text" class="form-control" name="doctor_title" required>
                            </div>

                            <!-- Sélection de la spécialité -->
                            <div class="mb-3">
                                <label for="id_spe">Spécialité</label>
                                <select name="id_spe" class="form-control" required>
                                    @foreach ($specialities as $specialty)
                                        <option value="{{ $specialty->id_spe }}">{{ $specialty->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_serv">Service</label>
                                <select name="id_serv" id="id_serv" class="form-control" required>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id_serv }}">{{ $service->serv_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
