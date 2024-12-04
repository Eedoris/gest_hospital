<div class="container">
    <h3>
        @if (isset($consultation))
            Modifier la consultation pour : {{ $patient->name }} {{ $patient->surname }}
        @else
            Ajouter une consultation pour : {{ $patient->name }} {{ $patient->surname }}
        @endif
    </h3>

    <!-- Formulaire -->
    <form
        action="{{ isset($consultation) ? route('consultations.update', $consultation->id) : route('consultations.store', $patient->id_pat) }}"
        method="POST">
        @csrf
        @if (isset($consultation))
            @method('PUT')
        @endif

        <!-- Date de consultation -->
        <div class="mb-3">
            <label for="date_cons" class="form-label">Date de consultation</label>
            <input type="date" name="date_cons" id="date_cons" class="form-control"
                   value="{{ isset($consultation) ? $consultation->date_cons : old('date_cons') }}" required>
            @error('date_cons')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Note/Diagnostic -->
        <div class="mb-3">
            <label for="note" class="form-label">Note/Diagnostic</label>
            <textarea name="note" id="note" class="form-control" rows="4" required>{{ isset($consultation) ? $consultation->note : old('note') }}</textarea>
            @error('note')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Analyses -->
        <div class="mb-3">
            <h4>Analyses</h4>
            <div id="analyses-container">
                @if (isset($consultation) && $consultation->analyses->isNotEmpty())
                    @foreach ($consultation->analyses as $index => $analyse)
                        <div class="row mb-2" id="analyse-{{ $index }}">
                            <div class="col">
                                <input type="text" name="analyses[{{ $index }}][libelle]" class="form-control"
                                       value="{{ $analyse->libelle }}" placeholder="Libellé de l'analyse" required>
                            </div>
                            <div class="col">
                                <input type="text" name="analyses[{{ $index }}][result]" class="form-control"
                                       value="{{ $analyse->result }}" placeholder="Résultat (optionnel)">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger" onclick="removeElement('analyse-{{ $index }}')">Supprimer</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row mb-2" id="analyse-0">
                        <div class="col">
                            <input type="text" name="analyses[0][libelle]" class="form-control" placeholder="Libellé de l'analyse" required>
                        </div>
                        <div class="col">
                            <input type="text" name="analyses[0][result]" class="form-control" placeholder="Résultat (optionnel)">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger" onclick="removeElement('analyse-0')">Supprimer</button>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-secondary" onclick="addAnalyse()">Ajouter une analyse</button>
        </div>

        <!-- Prescriptions -->
        <div class="mb-3">
            <h4>Prescriptions</h4>
            <div id="prescriptions-container">
                @if (isset($consultation) && $consultation->prescriptions->isNotEmpty())
                    @foreach ($consultation->prescriptions as $index => $prescription)
                        <div class="row mb-2" id="prescription-{{ $index }}">
                            <div class="col">
                                <input type="text" name="prescriptions[{{ $index }}][product]" class="form-control"
                                       value="{{ $prescription->product }}" placeholder="Produit" required>
                            </div>
                            <div class="col">
                                <input type="text" name="prescriptions[{{ $index }}][dosage]" class="form-control"
                                       value="{{ $prescription->dosage }}" placeholder="Dosage" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger" onclick="removeElement('prescription-{{ $index }}')">Supprimer</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row mb-2" id="prescription-0">
                        <div class="col">
                            <input type="text" name="prescriptions[0][product]" class="form-control" placeholder="Produit" required>
                        </div>
                        <div class="col">
                            <input type="text" name="prescriptions[0][dosage]" class="form-control" placeholder="Dosage" required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger" onclick="removeElement('prescription-0')">Supprimer</button>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-secondary" onclick="addPrescription()">Ajouter une prescription</button>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">
            {{ isset($consultation) ? 'Modifier la consultation' : 'Enregistrer la consultation' }}
        </button>
    </form>
</div>

<!-- Scripts pour gérer l'ajout/suppression dynamique -->
<script>
    let analyseIndex = {{ isset($consultation) ? $consultation->analyses->count() : 1 }};
    let prescriptionIndex = {{ isset($consultation) ? $consultation->prescriptions->count() : 1 }};

    function addAnalyse() {
        const container = document.getElementById('analyses-container');
        const rowId = `analyse-${analyseIndex}`;
        const row = `
            <div class="row mb-2" id="${rowId}">
                <div class="col">
                    <input type="text" name="analyses[${analyseIndex}][libelle]" class="form-control" placeholder="Libellé de l'analyse" required>
                </div>
                <div class="col">
                    <input type="text" name="analyses[${analyseIndex}][result]" class="form-control" placeholder="Résultat (optionnel)">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" onclick="removeElement('${rowId}')">Supprimer</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', row);
        analyseIndex++;
    }

    function addPrescription() {
        const container = document.getElementById('prescriptions-container');
        const rowId = `prescription-${prescriptionIndex}`;
        const row = `
            <div class="row mb-2" id="${rowId}">
                <div class="col">
                    <input type="text" name="prescriptions[${prescriptionIndex}][product]" class="form-control" placeholder="Produit" required>
                </div>
                <div class="col">
                    <input type="text" name="prescriptions[${prescriptionIndex}][dosage]" class="form-control" placeholder="Dosage" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" onclick="removeElement('${rowId}')">Supprimer</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', row);
        prescriptionIndex++;
    }

    function removeElement(id) {
        const element = document.getElementById(id);
        if (element) element.remove();
    }
</script>
