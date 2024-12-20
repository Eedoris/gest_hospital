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
                    <form action="{{ route('patientsupdate', $patient->uuid) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="form-label" for="name">Nom</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $patient->name) }}" placeholder="Nom..." required />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="form-label" for="surname">Prénoms</label>
                            <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname"
                                name="surname" value="{{ old('surname', $patient->surname) }}" placeholder="Prénoms..."
                                required />
                            @error('surname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="form-label" for="contact">Contact</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact"
                                name="contact" value="{{ old('contact', $patient->contact) }}" placeholder="Ex : 91234567"
                                required />
                            @error('contact')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="date_of_birth">Date de naissance</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                id="date_of_birth" name="date_of_birth" max="{{ date('Y-m-d') }}"
                                value="{{ old('date_of_birth', $patient->date_of_birth) }}" required />
                            @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="form-label" for="adress">Adresse</label>
                            <input type="text" class="form-control @error('adress') is-invalid @enderror" id="adress"
                                name="adress" value="{{ old('adress', $patient->adress) }}" placeholder="Adresse..."
                                required />
                            @error('adress')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="sex">Sexe</label>
                            <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex"
                                required>
                                <option value="" disabled>Choisissez le sexe</option>
                                <option value="{{ old('sex', $patient->sex) }}"
                                    {{ old('sex', $patient->sex) == 'Masculin' ? 'selected' : '' }}>
                                    Masculin
                                </option>
                                <option value="{{ old('sex', $patient->sex) }}"
                                    {{ old('sex', $patient->sex) == 'Feminin' ? 'selected' : '' }}>
                                    Féminin</option>
                            </select>
                            @error('sex')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Modifier</button>
                        <a href="{{ route('patientindex') }}" class="btn btn-secondary">Annuler</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
