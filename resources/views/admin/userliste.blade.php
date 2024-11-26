@extends('layouts.contentNavbarLayout')

@section('content')
    <div class="container">
        <h1>Gestion des utilisateurs</h1>

        <!-- Formulaire personnalisé -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Ajouter un utilisateur</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('userstore') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="surname" class="form-label">Prénom</label>
                            <input type="text" name="surname" id="surname" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="secretaire">Secrétaire</option>
                                <option value="gestionnaire">Gestionnaire</option>
                                <option value="medecin">Médecin</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Liste des utilisateurs</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->statut }}</td>
                                <td>
                                    <!-- Dropdown pour modifier ou supprimer -->
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- Bouton Modifier qui déclenche le modal -->
                                            <li>
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal-{{ $user->uuid }}">
                                                    <i class="fa fa-edit"></i> Modifier
                                                </a>
                                            </li>
                                            <!-- Bouton Supprimer qui déclenche le modal -->
                                            <li>
                                                <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal-{{ $user->uuid }}">
                                                    <i class="fa fa-trash"></i> Supprimer
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Modifier Utilisateur -->
                            <div class="modal fade" id="editUserModal-{{ $user->uuid }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('user.update', $user->uuid) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modifier Utilisateur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name">Nom</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="surname">Prénom</label>
                                                    <input type="text" class="form-control" name="surname"
                                                        value="{{ $user->surname }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="statut-{{ $user->uuid }}" class="form-label">Statut</label>
                                                  <select name="statut" id="statut-{{ $user->uuid }}" class="form-select" required>
                                                      <option value="admin" {{ $user->statut == 'admin' ? 'selected' : '' }}>Admin</option>
                                                      <option value="secretaire" {{ $user->statut == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                                      <option value="gestionnaire" {{ $user->statut == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                                                      <option value="medecin" {{ $user->statut == 'medecin' ? 'selected' : '' }}>Médecin</option>
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

                            <div class="modal fade" id="deleteUserModal-{{ $user->uuid }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Supprimer Utilisateur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('user.destroy', $user->uuid) }}" method="POST">
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
            </div>
        </div>

    </div>
@endsection