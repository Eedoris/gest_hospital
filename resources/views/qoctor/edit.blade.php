<div class="container">
    <h3>Modifier la consultation pour : {{ $patient->name }} {{ $patient->surname }}</h3>
    <form action="{{ route('consultations.update', $consultation->id_cons) }}" method="POST">
        @csrf


        <div class="mb-3">
            <label for="date_cons" class="form-label">Date de consultation</label>
            <input type="date" name="date_cons" id="date_cons" class="form-control"
                value="{{ old('date_cons', $consultation->date_cons) }}" required>
            @error('date_cons')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note/Diagnostic</label>
            <textarea name="note" id="note" class="form-control" rows="4" required>{{ old('note', $consultation->note) }}</textarea>
            @error('note')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <h4>Analyses</h4>
            <div id="analyses-container">
                @foreach ($consultation->analyses as $index => $analyse)
                    <div class="row mb-2" id="analyse-{{ $index }}">
                        <div class="col">
                            <input type="text" name="analyses[{{ $index }}][libelle]" class="form-control"
                                value="{{ old('analyses.' . $index . '.libelle', $analyse->libelle) }}"
                                placeholder="Libellé de l'analyse" required>
                        </div>
                        <div class="col">
                            <input type="text" name="analyses[{{ $index }}][result]" class="form-control"
                                value="{{ old('analyses.' . $index . '.result', $analyse->result) }}"
                                placeholder="Résultat (optionnel)">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger"
                                onclick="removeElement('analyse-{{ $index }}')">Supprimer</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary" onclick="addAnalyse()">Ajouter une analyse</button>
            @error('analyses.*.libelle')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <h4>Prescriptions</h4>
            <div id="prescriptions-container">
                @foreach ($consultation->prescriptions as $index => $prescription)
                    <div class="row mb-2" id="prescription-{{ $index }}">
                        <div class="col">
                            <input type="text" name="prescriptions[{{ $index }}][product]"
                                class="form-control"
                                value="{{ old('prescriptions.' . $index . '.product', $prescription->product) }}"
                                placeholder="Produit" required>
                        </div>
                        <div class="col">
                            <input type="text" name="prescriptions[{{ $index }}][dosage]"
                                class="form-control"
                                value="{{ old('prescriptions.' . $index . '.dosage', $prescription->dosage) }}"
                                placeholder="Dosage" required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger"
                                onclick="removeElement('prescription-{{ $index }}')">Supprimer</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary" onclick="addPrescription()">Ajouter une
                prescription</button>
            @error('prescriptions.*.product')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bouton de soumission --}}
        <button type="submit" class="btn btn-primary">Mettre à jour la consultation</button>
    </form>
</div>

<script>
    let analyseIndex = {{ count($consultation->analyses) }};
    let prescriptionIndex = {{ count($consultation->prescriptions) }};

    // Code pour ajouter/supprimer les analyses et prescriptions...
</script>
