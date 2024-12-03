<div class="container">
    <h3>Ajouter une consultation pour : {{ $patient->name }} {{ $patient->surname }}</h3>
    <form action="{{ route('consultations.store', $patient->id_pat) }}" method="POST">
        @csrf

        {{-- Champ pour la date de consultation --}}
        <div class="mb-3">
            <label for="date_cons" class="form-label">Date de consultation</label>
            <input type="date" name="date_cons" id="date_cons" class="form-control" required>
            @error('date_cons')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Champ pour la note/diagnostic --}}
        <div class="mb-3">
            <label for="note" class="form-label">Note/Diagnostic</label>
            <textarea name="note" id="note" class="form-control" rows="4" required></textarea>
            @error('note')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Section pour les analyses dynamiques --}}
        <div class="mb-3">
            <h4>Analyses</h4>
            <div id="analyses-container">
                <div class="row mb-2" id="analyse-0">
                    <div class="col">
                        <input type="text" name="analyses[0][libelle]" class="form-control"
                            placeholder="Libellé de l'analyse" required>
                    </div>
                    <div class="col">
                        <input type="text" name="analyses[0][result]" class="form-control"
                            placeholder="Résultat (optionnel)">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger"
                            onclick="removeElement('analyse-0')">Supprimer</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addAnalyse()">Ajouter une analyse</button>
            @error('analyses.*.libelle')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Section pour les prescriptions dynamiques --}}
        <div class="mb-3">
            <h4>Prescriptions</h4>
            <div id="prescriptions-container">
                <div class="row mb-2" id="prescription-0">
                    <div class="col">
                        <input type="text" name="prescriptions[0][product]" class="form-control"
                            placeholder="Produit" required>
                    </div>
                    <div class="col">
                        <input type="text" name="prescriptions[0][dosage]" class="form-control" placeholder="Dosage"
                            required>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger"
                            onclick="removeElement('prescription-0')">Supprimer</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addPrescription()">Ajouter une
                prescription</button>
            @error('prescriptions.*.product')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bouton de soumission --}}
        <button type="submit" class="btn btn-primary">Enregistrer la consultation</button>
    </form>
</div>

<script>
    let analyseIndex = 1;
    let prescriptionIndex = 1;

    // Ajout dynamique d'une analyse
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

    // Ajout dynamique d'une prescription
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

    // Suppression d'un élément dynamique
    function removeElement(id) {
        const element = document.getElementById(id);
        if (element) element.remove();
    }
</script>
