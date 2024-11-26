@extends('layouts/contentNavbarLayout')

@section('title', 'Consultations et Analyses du patient')

@section('content')
    <div class="container">
        <h3>Consultations du patient : {{ $patient->name }} {{ $patient->surname }}</h3>

        <!-- Bouton de retour -->
        <a href="{{ route('docpat') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-chevron-left"></i> Retour
        </a>


        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link @if (request()->get('fragment') == 'consultations' || !request()->has('fragment')) active @endif"
                    href="?fragment=consultations">Consultations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->get('fragment') == 'analyses') active @endif" href="?fragment=analyses">Analyses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->get('fragment') == 'prescriptions') active @endif"
                    href="?fragment=prescriptions">Prescriptions</a>
            </li>
        </ul>

        <div class="tab-content mt-4">

            <div class="tab-pane fade @if (request()->get('fragment') == 'consultations' || !request()->has('fragment')) show active @endif" id="consultations">

                <form action="{{ route('consultations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id_pat }}">
                    <div class="mb-3">
                        <label for="date_cons">Date de consultation</label>
                        <input type="date" class="form-control" id="date_cons" name="date_cons" required>
                    </div>
                    <div class="mb-3">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="note" name="note" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter consultation</button>
                </form>

                <hr class="my-12">

                @if (session('success_consultation'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_service') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <hr class="my-4">
                <h4>Liste des consultations</h4>
                <ul class="list-group">
                    @foreach ($consultations as $consultation)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Date : {{ $consultation->date_cons }}</h5>
                                <h6>Note : {{ $consultation->note }}</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#editConsultationModal-{{ $consultation->id_cons }}">
                                        <i class="fa fa-edit"></i> Modifier
                                    </a>
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#deleteConsultationModal-{{ $consultation->id_cons }}">
                                        <i class="fa fa-trash"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        </li>


                        <div class="modal fade" id="editConsultationModal-{{ $consultation->id_cons }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('consultations.update', $consultation->id_cons) }}"
                                        method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier Consultation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="date_cons">Date</label>
                                                <input type="date" class="form-control" name="date_cons"
                                                    value="{{ $consultation->date_cons }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="note">Note</label>
                                                <textarea class="form-control" name="note" required>{{ $consultation->note }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="deleteConsultationModal-{{ $consultation->id_cons }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Supprimer Consultation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer cette consultation ?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('consultations.destroy', $consultation->id_cons) }}"
                                            method="POST">
                                            @csrf

                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            </div>


            <div class="tab-pane fade @if (request()->get('fragment') == 'analyses') show active @endif" id="analyses">
                <form action="{{ route('analysestore') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="libelle">Nom de l'analyse</label>
                        <select class="form-control" id="libelle" name="libelle" required>
                            @foreach ($an_disponibles as $an_disponible)
                                <option value="{{ $an_disponible->libelle }}">{{ $an_disponible->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_res">Date de réalisation</label>
                        <input type="date" class="form-control" id="date_res" name="date_res" required>
                    </div>
                    <div class="mb-3">
                        <label for="state">État</label>
                        <select class="form-control" id="state" name="state" required>
                            <option value="termine">Effectué</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="result">Description</label>
                        <textarea class="form-control" id="result" name="result" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter une analyse</button>
                </form>

                <hr class="my-4">
                @if (session('success_analyse'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_analyse') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <hr class="my-4">
                <h4>Liste des analyses</h4>
                <ul class="list-group">
                    @foreach ($analyses as $analyse)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Libellé : {{ $analyse->libelle }}</h5>
                                <p>Date de réalisation : {{ $analyse->date_res }}</p>
                                <p>État : {{ ucfirst($analyse->state) }}</p>
                                <p>Description : {{ $analyse->result }}</p>
                            </div>
                            <div class="dropdown ms-auto">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#editAnalyseModal-{{ $analyse->id_an }}">
                                        <i class="fa fa-edit"></i> Modifier
                                    </a>
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#deleteAnalyseModal-{{ $analyse->id_an }}">
                                        <i class="fa fa-trash"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        </li>

                        <div class="modal fade" id="editAnalyseModal-{{ $analyse->id_an }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('analyseupdate', $analyse->id_an) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier Analyse</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="libelle">Nom de l'analyse</label>
                                                <input type="text" class="form-control" name="libelle"
                                                    value="{{ $analyse->libelle }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="date_res">Date de réalisation</label>
                                                <input type="date" class="form-control" name="date_res"
                                                    value="{{ $analyse->date_res }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="state">État</label>
                                                <select class="form-control" name="state" required>
                                                    <option value="termine"
                                                        @if ($analyse->state == 'termine') selected @endif>Effectué</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="result">Description</label>
                                                <textarea class="form-control" name="result" required>{{ $analyse->result }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteAnalyseModal-{{ $analyse->id_an }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Supprimer Analyse</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer cette analyse ?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('analysedestroy', $analyse->id_an) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            </div>



            <div class="tab-pane fade @if (request()->get('fragment') == 'prescriptions') show active @endif" id="prescriptions">
                <h4>Liste des prescriptions</h4>
                <p>À implémenter...</p>
            </div>
        </div>
    </div>
@endsection
