<div class="container mt-4">
    <h3>Historique des consultations pour : {{ $patient->name }} {{ $patient->surname }}</h3>

    @if (session('success_history'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success_history') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($consultations as $consultation)
            <div class="col-md-4 ">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Consultation du {{ $consultation->date_cons }}</h5>
                        <p class="card-text"><strong>Diagnostic :</strong> {!! nl2br(e($consultation->note)) !!}</p>
                        <hr>
                        <h6>Analyses :</h6>
                        @forelse($consultation->analyses as $analyse)
                            <p>- {{ $analyse->libelle }} : {{ $analyse->result ?? 'N/A' }}</p>
                        @empty
                            <p>Aucune analyse</p>
                        @endforelse
                        <hr>
                        <h6>Prescriptions :</h6>
                        @forelse($consultation->prescriptions as $prescription)
                            <p>- {{ $prescription->product }} ({{ $prescription->dosage }})</p>
                        @empty
                            <p>Aucune prescription</p>
                        @endforelse
                    </div>
                    <div class="card-footer d-flex gap-2">
                        <button class="btn btn-warning btn-sm " data-bs-toggle="modal"
                            data-bs-target="#editConsultationModal-{{ $consultation->id_cons }}">Modifier</button>


                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteConsultationModal-{{ $consultation->id_cons }}">Supprimer</button>

                        <!-- Imprimer -->
                        <a href="{{ route('consultations.print', $consultation->id_cons) }}"
                            class="btn btn-secondary btn-sm" target="_blank">Imprimer</a>
                    </div>
                </div>
            </div>

            <!-- Modal de modification -->
            <div class="modal fade" id="editConsultationModal-{{ $consultation->id_cons }}" tabindex="-1"
                aria-labelledby="editConsultationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('consultations.update', $consultation->id_cons) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="editConsultationModalLabel">Modifier la consultation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Champ pour la date -->
                                <div class="mb-3">
                                    <label for="date_cons" class="form-label">Date</label>
                                    <input type="date" name="date_cons" value="{{ $consultation->date_cons }}"
                                        class="form-control" required>
                                </div>
                                <!-- Champ pour le diagnostic -->
                                <div class="mb-3">
                                    <label for="note" class="form-label">Diagnostic</label>
                                    <textarea name="note" class="form-control" rows="4" required>{{ $consultation->note }}</textarea>
                                </div>
                                <!-- Section pour les analyses -->
                                <div class="mb-3">
                                    <label for="analyses" class="form-label">Analyses</label>
                                    @forelse($consultation->analyses as $analyse)
                                        <div class="input-group mb-2">
                                            <input type="text" name="analyses[{{ $analyse->id_an }}][libelle]"
                                                value="{{ $analyse->libelle }}" class="form-control"
                                                placeholder="Libellé" required>
                                            <input type="text" name="analyses[{{ $analyse->id_an }}][result]"
                                                value="{{ $analyse->result }}" class="form-control"
                                                placeholder="Résultat">
                                        </div>
                                    @empty
                                        <p class="text-muted">Aucune analyse pour cette consultation.</p>
                                    @endforelse
                                </div>
                                <!-- Section pour les prescriptions -->
                                <div class="mb-3">
                                    <label for="prescriptions" class="form-label">Prescriptions</label>
                                    @forelse($consultation->prescriptions as $prescription)
                                        <div class="input-group mb-2">
                                            <input type="text"
                                                name="prescriptions[{{ $prescription->id_pres }}][product]"
                                                value="{{ $prescription->product }}" class="form-control"
                                                placeholder="Produit" required>
                                            <input type="text"
                                                name="prescriptions[{{ $prescription->id_pres }}][dosage]"
                                                value="{{ $prescription->dosage }}" class="form-control"
                                                placeholder="Dosage">
                                        </div>
                                    @empty
                                        <p class="text-muted">Aucune prescription pour cette consultation.</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal de suppression -->
            <div class="modal fade" id="deleteConsultationModal-{{ $consultation->id_cons }}" tabindex="-1"
                aria-labelledby="deleteConsultationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('consultations.destroy', $consultation->id_cons) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteConsultationModalLabel">Supprimer la consultation
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cette consultation ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Aucune consultation disponible.</p>
        @endforelse
    </div>
</div>
