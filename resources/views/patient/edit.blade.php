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
                            <label class="form-label" for="basic-default-fullname">Nom</label>
                            <input type="text" class="form-control" id="basic-default-fullname" name="name"
                                value="{{ $patient->name }}" placeholder="nom..." />
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-company">Prenoms</label>
                            <input type="text" class="form-control" id="basic-default-company" name="surname"
                                value="{{ $patient->surname }}" placeholder="prenoms..." />
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-phone">Contact:</label>
                            <input type="text" id="basic-default-phone" class="form-control phone-mask"
                                value="{{ $patient->contact }}" name="contact" placeholder="658 799 8941" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="date_of_birth">Date de naissance</label>
                            <input type="date" class="form-control" id="date_of_birth"
                                value="{{ $patient->date_of_birth }}" name="date_of_birth" required />
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-company">Adresse</label>
                            <input type="text" class="form-control" id="basic-default-company" name="adress"
                                value="{{ $patient->adress }}" placeholder="Adresse" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sex">Sexe</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="Male" {{ $patient->sex == 'Male' ? 'selected' : '' }}>Masculin</option>
                                <option value="Female" {{ $patient->sex == 'Female' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection