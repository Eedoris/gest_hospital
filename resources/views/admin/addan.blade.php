@extends('layouts/contentNavbarLayout')

@section('title', 'service & analyses')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link @if (request()->get('fragment') == 'services' || !request()->has('fragment')) active @endif" data-bs-toggle="tab" href="#services">
                    Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->get('fragment') == 'analyses_dispo') active @endif" data-bs-toggle="tab"
                    href="#analyses_dispo">
                    Analyses
                </a>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade @if (request()->get('fragment') == 'services' || !request()->has('fragment')) show active @endif" id="services">

                <form action="{{ route('servicestore') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="date_cons">Nom du service</label>
                        <input type="text" class="form-control" id="serv_name" name="serv_name" required>
                    </div>
                    <h2 class="my-5"></h2>
                    <div class="mb-3">
                        <label for="note">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Ajouter un service </button>
                </form>

                <hr class="my-12">

                @if (session('success_service'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_service') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h4>Liste des services disponibles</h4>
                <ul class="list-group">
                    @foreach ($services as $service)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Service : {{ $service->serv_name }}</h5>
                                <h6>Description : {{ $service->description }}</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $service->id_serv }}">
                                        <i class="fa fa-edit"></i> Modifier
                                    </a>
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal-{{ $service->id_serv }}">
                                        <i class="fa fa-trash"></i> Supprimer
                                    </a>

                                </div>
                            </div>
                        </li>

                        <div class="modal fade" id="editModal-{{ $service->id_serv }}" tabindex="-1"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('servicesupdate', $service->id_serv) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Modifier le service</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="serv_name">Nom du service</label>
                                                <input type="text" class="form-control" id="serv_name" name="serv_name"
                                                    value="{{ $service->serv_name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description" required>{{ $service->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!--<button type="button" class="btn btn-secondary"
                                                                                                                                                                                                                                                              data-bs-dismiss="modal">Annuler</button>-->
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteModal-{{ $service->id_serv }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer le service
                                        <strong>{{ $service->serv_name }}</strong> ?
                                    </div>
                                    <div class="modal-footer">
                                        <!--<button type="button" class="btn btn-secondary"
                                                                                                                                                                    data-bs-dismiss="modal">Annuler</button>-->
                                        <form id="delete-service-{{ $service->id_serv }}"
                                            action="{{ route('services.destroy', $service->id_serv) }}" method="POST"
                                            style="display: inline;">
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


            <div class="tab-pane fade @if (request()->get('fragment') == 'analyses_dispo') show active @endif" id="analyses_dispo">

                <form action="{{ route('analyses.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="libelle">Nom de l'analyse</label>
                        <input type="text" class="form-control" id="libelle" name="libelle" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter une analyse</button>
                </form>

                <hr class="my-4">
                @if (session('success_analysis'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_analysis') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h4>Liste des analyses disponibles</h4>
                <ul class="list-group">
                    @foreach ($an_disponibles as $an_disponible)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>{{ $an_disponible->libelle }}</div>
                            <div class="dropdown ms-auto">
                                <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#deleteModalAnalyse-{{ $an_disponible->id }}">
                                        <i class="fa fa-trash"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- Modal Supprimer Analyse -->
                        <div class="modal fade" id="deleteModalAnalyse-{{ $an_disponible->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabelAnalyse" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmation de suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer l'analyse
                                        <strong>{{ $an_disponible->libelle }}</strong> ?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('analyses.destroy', $an_disponible->id) }}"
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
        </div>
    </div>
    <!--<script>
        // Activer le bon onglet sur la base du fragment de l'URL
        document.addEventListener('DOMContentLoaded', function() {
            const fragment = window.location.hash;
            if (fragment) {
                const tab = document.querySelector(`a[href="${fragment}"]`);
                if (tab) {
                    new bootstrap.Tab(tab).show();
                }
            }
        });
    </script>-->
@endsection
