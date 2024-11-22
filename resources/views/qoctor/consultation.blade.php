@extends('layouts/contentNavbarLayout')

@section('title', 'Consultations du patient')

@section('content')
    <div class="container">
        <h3>Consultations du patient : {{ $patient->name }} {{ $patient->surname }}</h3>

        <!-- Icône de retour avec un lien -->
        <a href="{{ route('docpat') }}" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            </svg>

        </a>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#consultations">Consultations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#analyses">Analyses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#prescriptions">Prescriptions</a>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="consultations">

                <form action="{{ route('consultations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id_pat }}">
                    <div class="mb-3">
                        <label for="date_cons">Date de consultation</label>
                        <input type="date" class="form-control" id="date_cons" name="date_cons" required>
                    </div>
                    <h2 class="my-5"></h2>
                    <div class="mb-3">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="note" name="note" required></textarea>
                    </div>
                    <!--
                                                                        <div class="mb-3">
                                                                            <label>Analyses disponibles</label>
                                                                            <h2 class="my-5"></h2>
                                                                            <div>
                                                                                @foreach ($analyses as $analyse)
    <div class="form-check">
                                                                                        <input class="form-check-input" type="checkbox" name="analyses[]"
                                                                                            value="{{ $analyse->id_an }}" id="analyse_{{ $analyse->id_an }}">
                                                                                        <label class="form-check-label" for="analyse_{{ $analyse->id_an }}">
                                                                                            {{ $analyse->libelle }}
                                                                                        </label>
                                                                                    </div>
    @endforeach
                                                                            </div>
                                                                        </div>-->


                    <button type="submit" class="btn btn-success">Ajouter consultation</button>
                </form>

                <hr class="my-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h4>Liste des consultations</h4>
                <ul class="list-group">
                    @foreach ($consultations as $consultation)
                        <li class="list-group-item">
                            <h5>Date : {{ $consultation->date_cons }}</h5>
                            <h6>Note : {{ $consultation->note }}</h6>

                            <!--
                                                                                @if ($consultation->analyses->isEmpty())
    <p>Aucune analyse associée</p>
@else
    <ul>
                                                                                        @foreach ($consultation->analyses as $analyse)
    <li>{{ $analyse->libelle }}</li>
    @endforeach
                                                                                    </ul>
    @endif
                                                                                  -->

                        </li>
                    @endforeach

                </ul>

            </div>

            <!-- Analyses -->
            <div class="tab-pane fade" id="analyses">
                <form action="{{ route('analysestore') }}" method="POST">
                    @csrf


                    <div class="mb-4">
                        <label class="form-label" for="libelle">Selectionner l'analyse</label>
                        <select class="form-control" id="libelle" name="libelle" required>
                            @foreach ($an_disponibles as $an_disponible)
                                <option value="{{ $an_disponible->libelle }}">{{ $an_disponible->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="date_res">Date de realisation </label>
                        <input type="date" class="form-control" id="date_res" name="date_res" required>
                    </div>
                    <select class="form-control" id="state" name="state" required>

                        <option value="termine">Effectué</option>

                    </select>
                    <h2 class="my-4"></h2>

                    <div class="mb-4">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="result" name="result" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </form>

                <hr class="my-12">
                <h4>Liste des analyses</h4>
                @if ($analyses->isEmpty())
                    <p>Aucune analyse enregistrée.</p>
                @else
                    <ul class="list-group">
                        @foreach ($analyses as $analyse)
                            <li class="list-group-item">
                                <strong>Libellé :</strong> {{ $analyse->libelle }} <br>
                                <strong>Date :</strong> {{ $analyse->date_res }} <br>
                                <strong>Description :</strong> {{ $analyse->description ?? 'Non spécifiée' }}
                                <a class="dropdown-item"> <i class="fa fa-edit"></i> Modifier </a>

                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>

            <!-- Prescriptions -->
            <div class="tab-pane fade" id="prescriptions">
                <h4>Liste des prescriptions</h4>
                <p>À implémenter avec les données des prescriptions...</p>
            </div>
        </div>
    </div>
@endsection
