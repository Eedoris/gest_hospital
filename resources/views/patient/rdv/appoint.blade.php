@extends('layouts/contentNavbarLayout')

@section('content')
    <!-- Basic Buttons -->
    <div class="row g-6">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="demo-inline-spacing">
                        <a href="{{ route('createappoint') }}" class="btn btn-primary"> Agencer un rendez-vous </a>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" data-bs-toggle="tab" href="#prevu" role="tab">Prévu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#effectue" role="tab">Effectué</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#annule" role="tab">Annulé</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-bs-toggle="tab" href="#reprogramme" role="tab">Reprogrammé</a>
            </li>
        </ul>

        <div class="tab-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <div class="tab-pane fade show active" id="prevu" role="tabpanel">
                <!-- Table des rendez-vous Prévu -->
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="data_list">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>service</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($appoints as $appoint)
                                <tr>
                                    <td>{{ $appoint->name }}</td>
                                    <td>{{ $appoint->surname }}</td>
                                    <td>{{ $appoint->contact }} </td>
                                    <td>{{ $appoint->date_app->translatedFormat('d/m/Y') }}</td>
                                    <td id="heure">{{ $appoint->time_app }}</td>
                                    <td>{{ $appoint->service->serv_name }}</td>

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('appoint.cancel', ['id' => encrypt($appoint->id_appoint)]) }}">
                                                    <i class="fa fa-times-circle"></i> Annuler
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('appoint.complete', ['id' => encrypt($appoint->id_appoint)]) }}">
                                                    <i class="fa fa-check-circle"></i> Effectuer
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('appoint.showRescheduleForm', $appoint->id_appoint) }}"
                                                    class="btn btn-warning"> <i class="fa fa-calendar">Reprogrammer</a>


                                                <a class="dropdown-item"
                                                    href="{{ route('appoint.edit', ['token' => encrypt($appoint->id_appoint)]) }}">
                                                    <i class="fa fa-edit"></i> Repro
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tbody class="table-border-bottom-0">
                          @foreach ($appoints as $appoint)
                              <tr class="item">
                                  <td>{{ $appoint->name }}</td>
                                  <td>{{ $appoint->surname }}</td>
                                  <td>{{ $appoint->contact }} </td>
                                  <td>{{ $appoint->date_app }} </td>
                                  <td>{{ $appoint->time_app }}</td>
                                  <td>{{ $appoint->service->serv_name }}</td>


                                  <td>
                                      <div class="dropdown">
                                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                              data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                          <div class="dropdown-menu">
                                              <a class="dropdown-item"
                                                  href="{{ route('appoint.edit', ['token' => encrypt($appoint->id_appoint)]) }}">
                                                  <i class="fa fa-edit"></i> Modifier
                                              </a>
                                          </div>
                                      </div>
                                  </td>
                              </tr>
                          @endforeach

                      </tbody> --}}
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="effectue" role="tabpanel">
                <!-- Table des rendez-vous Effectué -->
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="data_list">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Contact</th>
                                <th>Date du rendez-vous</th>
                                <th>Heure</th>
                                <th>service</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($completes as $complete)
                                <tr>
                                    <td>{{ $complete->name }}</td>
                                    <td>{{ $complete->surname }}</td>
                                    <td>{{ $complete->contact }} </td>
                                    <td>{{ $complete->date_app->translatedFormat('d/m/Y') }}</td>
                                    <td id="heure">{{ $complete->time_app }}</td>
                                    <td>{{ $complete->service->serv_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="annule" role="tabpanel">
                <!-- Table des rendez-vous Annulé -->
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="data_list">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Contact</th>
                                <th>Date du rendez-vous</th>
                                <th>Heure</th>
                                <th>service</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->name }}</td>
                                    <td>{{ $appointment->surname }}</td>
                                    <td>{{ $appointment->contact }} </td>
                                    <td>{{ $appointment->date_app->translatedFormat('d/m/Y') }}</td>
                                    <td id="heure">{{ $appointment->time_app }}</td>
                                    <td>{{ $appointment->service->serv_name }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="reprogramme" role="tabpanel">
                <!-- Table des rendez-vous Reprogrammé -->
            </div>
        </div>


        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <h5 class="card-header">Rendez-vous</Rendez-vous></h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="data_list">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Contact</th>
                            <th>Date du rendez-vous</th>
                            <th>Heure</th>
                            <th>service</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($appoints as $appoint)
                            <tr class="item">
                                <td>{{ $appoint->name }}</td>
                                <td>{{ $appoint->surname }}</td>
                                <td>{{ $appoint->contact }} </td>
                                <td>{{ $appoint->date_app }} </td>
                                <td>{{ $appoint->time_app }}</td>
                                <td>{{ $appoint->service->serv_name }}</td>


                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('appoint.edit', ['token' => encrypt($appoint->id_appoint)]) }}">
                                                <i class="fa fa-edit"></i> Modifier
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div> --}}
        <script>
            let heureElement = document.getElementById('heure');
            let fullTime = heureElement.textContent; // Format: 10:15:30
            let formattedTime = fullTime.substring(0, 5); // Garde uniquement h:m
            heureElement.textContent = formattedTime;

            document.addEventListener('DOMContentLoaded', function() {
                let urlParams = new URLSearchParams(window.location.search);
                let activeTab = urlParams.get('tab') || 'defaultTab';

                // Activer l'onglet en fonction du paramètre `tab`
                document.querySelector(`#${activeTab}`).classList.add('active');
                document.querySelector(`#${activeTab}-content`).classList.add('show', 'active');
            });
        </script>
        <script src="{{ asset('js/search.js') }}"></script>
    @endsection
