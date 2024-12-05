@extends('layouts/contentNavbarLayout')

@section('title', 'Vertical Layouts - Forms')

@section('content')


    <div class="row">
        <div class="col-xl">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rendez-vous</h5> <small class="text-body float-end">Fiche</small>
                </div>

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
                    <form action="{{ route('appointstore') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="form-label" for="patient_name">Nom du patient</label>
                            <input type="text" class="form-control" id="patient_name" name="name"
                                placeholder="Rechercher un patient..." />
                        </div>
                        <div id="patient-results"></div>

                        <div class="mb-6">
                            <label class="form-label" for="contact">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" readonly>
                        </div>

                        <div class="mb-6">
                            <label class="form-label" for="basic-default-company">Prénoms</label>
                            <input type="text" class="form-control" id="basic-default-company" name="surname"
                                placeholder="Prénoms..." />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="date_rdv">Date</label>
                            <input type="date" class="form-control" id="date_rdv" max="{{ date('Y-m-d') }}" name="date_app" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="time_app">Heure</label>
                            <input type="time" class="form-control" id="time_app" name="time_app" required />
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

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
                $('#basic-default-company').val(surname);
                $('#contact').val(contact);


                $('#patient-results').empty();
            });
        });
    </script>
@endsection
