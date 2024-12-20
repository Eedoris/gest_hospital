<style>
    .card-footer {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;

    }
</style>



{{-- <h5>Historique des consultations pour : {{ $patient->name }} {{ $patient->surname }}</h5> --}}

@if (session('success_history'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success_history') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    @forelse($consultations as $consultation)
        <div class="col-md-5" id="search">
            <div class="card mb-5 card-container">
                <div class="card-body ">
                    {{-- <h5 class="card-title">Consultation du {{ $consultation->date_cons }}</h5> --}}
                    <h5 class="card-title">Consultation du
                        {{ \Carbon\Carbon::parse($consultation->date_cons)->format('d/m/Y') }}</h5>

                    <p class="card-text"><strong>Symptomes:</strong> {!! nl2br(e($consultation->symptome)) !!}</p>
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
                <div class="card-footer demo-inline-spacing">
                    <a href="{{ route('consultations.edit', $consultation->id_cons) }}"
                        class="btn btn-primary  btn ">Modifier</a>

                    <!--<button class="btn btn-danger btn-sm " data-bs-toggle="modal"
                    data-bs-target="#deleteConsultationModal-{{ $consultation->id_cons }}">Supprimer</button>-->

                    <!-- Imprimer -->
                    <a href="{{ route('consultations.print', $consultation->id_cons) }}" class="btn btn-secondary btn "
                        target="_blank">Imprimer</a>
                </div>
            </div>
        </div>

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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
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
<script>
    document.getElementById('global_search').addEventListener('input', function() {
        filterCards('search', 'global_search'); // 'search' correspond à l'ID contenant toutes les cartes
    });

    function filterCards(containerId, searchInputId) {
        let query = document.getElementById(searchInputId).value.toLowerCase();
        let cards = document.querySelectorAll(`#${containerId} .card-container`);

        cards.forEach(card => {
            let cardText = card.textContent.toLowerCase();
            card.style.display = cardText.includes(query) ? '' : 'none';
        });
    }
</script>
