@extends('layouts/contentNavbarLayout')

@section('title', 'Modifier Rendez-vous')

@section('content')

    <div class="row">
        <div class="col-xl">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Modifier Rendez-vous</h5>
                    <small class="text-body float-end">Mise à jour</small>
                </div>

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
                    <form action="{{ route('appoint.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ encrypt($appoint->id_appoint) }}">


                        <!-- Recherche du patient -->
                        <div class="mb-6">
                            <label class="form-label" for="patient_name">Nom du patient</label>
                            <input type="text" class="form-control" id="patient_name" name="name"
                                value="{{ $appoint->name }}" placeholder="Rechercher un patient..." />
                        </div>
                        <div id="patient-results"></div>

                        <!-- Contact du patient -->
                        <div class="mb-6">
                            <label class="form-label" for="contact">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact"
                                value="{{ $appoint->contact }}" readonly>
                        </div>

                        <!-- Prénom -->
                        <div class="mb-6">
                            <label class="form-label" for="surname">Prénom</label>
                            <input type="text" class="form-control" id="surname" name="surname"
                                value="{{ $appoint->surname }}" placeholder="Prénoms..." />
                        </div>

                        <!-- Date du rendez-vous -->
                        <div class="mb-3">
                            <label class="form-label" for="date_rdv">Date</label>
                            <input type="date" class="form-control" id="date_rdv" name="date_app"
                                value="{{ $appoint->date_app }}" required />
                        </div>

                        <!-- Heure du rendez-vous -->
                        <div class="mb-3">
                            <label class="form-label" for="time_rdv">Heure</label>
                            <input type="time" class="form-control" id="time_rdv" name="time_app"
                                value="{{ $appoint->time_app }}" required />
                        </div>


                        <!-- Sélectionner un service -->
                        <div class="mb-3">
                            <label class="form-label" for="id_serv">Sélectionner un service</label>
                            <select class="form-control" id="id_serv" name="service_id" required>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Recherche des patients lorsque l'utilisateur tape dans le champ "Nom du patient"
            $('#patient_name').on('input', function() {
                var name = $(this).val().trim();

                if (name.length >= 2) {
                    $.ajax({
                        url: "{{ route('patients.search') }}",
                        method: 'GET',
                        data: {
                            name: name
                        },
                        success: function(response) {
                            $('#patient-results').empty();

                            // Si des patients sont trouvés
                            if (response.length > 0) {
                                var resultsHtml = '<ul class="list-group">';
                                response.forEach(function(patient) {
                                    resultsHtml += `
                                    <li class="list-group-item patient-item"
                                        data-id="${patient.id_pat}"
                                        data-name="${patient.name}"
                                        data-surname="${patient.surname}"
                                        data-contact="${patient.contact || ''}">
                                        ${patient.name} ${patient.surname}
                                    </li>`;
                                });
                                resultsHtml += '</ul>';
                                $('#patient-results').html(resultsHtml);
                            } else {
                                $('#patient-results').html('<p>Aucun patient trouvé.</p>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Erreur AJAX :", error);
                            $('#patient-results').html(
                                '<p class="text-danger">Une erreur est survenue. Veuillez réessayer.</p>'
                            );
                        }
                    });
                } else {
                    $('#patient-results').empty();
                }
            });


            $(document).on('click', '.patient-item', function() {
                var name = $(this).data('name');
                var surname = $(this).data('surname');
                var contact = $(this).data('contact');

                $('#patient_name').val(name);
                $('#surname').val(surname);
                $('#contact').val(contact);


                $('#patient-results').empty();
            });
        });
    </script>

@endsection
