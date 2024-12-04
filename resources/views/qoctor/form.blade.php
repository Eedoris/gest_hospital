<div class="container">
    <h3>
        @if (isset($consultation))
            Modifier la consultation pour : {{ $patient->name }} {{ $patient->surname }}
        @else
            Ajouter une consultation pour : {{ $patient->name }} {{ $patient->surname }}
        @endif
    </h3>

    <form
        action="{{ isset($consultation) ? route('consultations.update', $consultation->id_cons) : route('consultations.store', $patient->id_pat) }}"
        method="POST">
        @csrf
        @if (isset($consultation))
            @method('POST')
        @endif

        <!-- Date de consultation -->
        <div class="mb-3">
            <label for="date_cons" class="form-label">Date de consultation</label>
            <input type="date" name="date_cons" id="date_cons" class="form-control"
                value="{{ isset($consultation) ? $consultation->date_cons : '' }}" required>
            @error('date_cons')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Note/Diagnostic -->
        <div class="mb-3">
            <label for="note" class="form-label">Note/Diagnostic</label>
            <textarea name="note" id="note" class="form-control" rows="4" required>{{ isset($consultation) ? $consultation->note : '' }}</textarea>
            @error('note')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Analyses -->
        <div class="mb-3">
            <h4>Analyses</h4>
            <div id="analyses-container">
                @if (isset($consultation) && $consultation->analyses->isNotEmpty())
                    @foreach ($consultation->analyses as $analyse)
                        <div class="row mb-2" id="analyse-{{ $analyse->id_an }}">
                            <div class="col">
                                <input type="text" name="analyses[{{ $analyse->id_an }}][libelle]"
                                    class="form-control" value="{{ $analyse->libelle }}"
                                    placeholder="Libellé de l'analyse" required>
                            </div>
                            <div class="col">
                                <input type="text" name="analyses[{{ $analyse->id_an }}][result]"
                                    class="form-control" value="{{ $analyse->result }}"
                                    placeholder="Résultat (optionnel)">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger"
                                    onclick="handleDelete('analyse', '{{ $analyse->id_an ?? 'new_' . $loop->index }}')">Supprimer</button>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <input type="hidden" name="analyses_to_delete" id="analyses_to_delete">

            <button type="button" class="btn btn-secondary" onclick="addAnalyse()">Ajouter une analyse</button>
        </div>

        <!-- Prescriptions -->
        <div class="mb-3">
            <h4>Prescriptions</h4>
            <div id="prescriptions-container">
                @if (isset($consultation) && $consultation->prescriptions->isNotEmpty())
                    @foreach ($consultation->prescriptions as $prescription)
                        <div class="row mb-2" id="prescription-{{ $prescription->id_pres }}">
                            <div class="col">
                                <input type="text" name="prescriptions[{{ $prescription->id_pres }}][product]"
                                    class="form-control" value="{{ $prescription->product }}" placeholder="Produit"
                                    required>
                            </div>
                            <div class="col">
                                <input type="text" name="prescriptions[{{ $prescription->id_pres }}][dosage]"
                                    class="form-control" value="{{ $prescription->dosage }}" placeholder="Dosage"
                                    required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger"
                                    onclick="handleDelete('prescription', '{{ $prescription->id_pres ?? 'new_' . $loop->index }}')">Supprimer</button>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <input type="hidden" name="prescriptions_to_delete" id="prescriptions_to_delete">

            <button type="button" class="btn btn-secondary" onclick="addPrescription()">Ajouter une
                prescription</button>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">
            {{ isset($consultation) ? 'Modifier la consultation' : 'Enregistrer la consultation' }}
        </button>
    </form>
</div>
<!-- Scripts pour gérer l'ajout/suppression dynamique -->
<script>
    let analyseIndex = {{ isset($consultation) ? $consultation->analyses->count() : 0 }};
    let prescriptionIndex = {{ isset($consultation) ? $consultation->prescriptions->count() : 0 }};

    function addAnalyse() {
        const container = document.getElementById('analyses-container');
        const rowId = `analyse-new-${analyseIndex}`;
        const row = `
    <div class="row mb-2" id="${rowId}">
        <div class="col">
            <input type="text" name="analyses[new_${analyseIndex}][libelle]" class="form-control" placeholder="Libellé de l'analyse" required>
        </div>
        <div class="col">
            <input type="text" name="analyses[new_${analyseIndex}][result]" class="form-control" placeholder="Résultat (optionnel)">
        </div>
        <div class="col-auto">
         <button type="button" class="btn btn-danger" onclick="handleDynamicRemove('${rowId}')">Supprimer</button>
        </div>
    </div>`;
        container.insertAdjacentHTML('beforeend', row);
        analyseIndex++;
    }

    function addPrescription() {
        const container = document.getElementById('prescriptions-container');
        const rowId = `prescription-new-${prescriptionIndex}`;
        const row = `
    <div class="row mb-2" id="${rowId}">
        <div class="col">
            <input type="text" name="prescriptions[new_${prescriptionIndex}][product]" class="form-control" placeholder="Produit" required>
        </div>
        <div class="col">
            <input type="text" name="prescriptions[new_${prescriptionIndex}][dosage]" class="form-control" placeholder="Dosage" required>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger" onclick="handleDynamicRemove('${rowId}')">Supprimer</button>
        </div>
        </div>
    </div>`;
        container.insertAdjacentHTML('beforeend', row);
        prescriptionIndex++;
    }

    function handleDynamicRemove(rowId) {
        const element = document.getElementById(rowId);
        if (element) {
            element.remove();
            console.log(`Dynamically removed element: ${rowId}`);
        }
    }

    let analysesToDelete = [];
    let prescriptionsToDelete = [];

    function handleDelete(type, id) {
        const element = document.getElementById(`${type}-${id}`);
        if (element) {
            element.remove();

            if (!id.startsWith('new_')) {
                if (type === 'analyse') {
                    analysesToDelete.push(id);
                    document.getElementById('analyses_to_delete').value = analysesToDelete.join(',');
                } else if (type === 'prescription') {
                    prescriptionsToDelete.push(id);
                    document.getElementById('prescriptions_to_delete').value = prescriptionsToDelete.join(',');
                }
            }
            console.log(`Handled delete for: ${type} - ${id}`);
        }
    }
</script>
