<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation - Impression</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h3 {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .content {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Fiche de Consultation</h1>
    <h2>Consultation du {{ $consultation->date_cons }}</h2>
    <div class="section">
        <h3>Diagnostic</h3>
        <div class="content">
            {!! nl2br(e($consultation->note)) !!}
        </div>
    </div>
    <div class="section">
        <h3>Analyses</h3>
        <div class="content">
            @forelse($consultation->analyses as $analyse)
                <p>- {{ $analyse->libelle }} : {{ $analyse->result ?? 'N/A' }}</p>
            @empty
                <p>Aucune analyse effectuée.</p>
            @endforelse
        </div>
    </div>
    <div class="section">
        <h3>Prescriptions</h3>
        <div class="content">
            @forelse($consultation->prescriptions as $prescription)
                <p>- {{ $prescription->product }} ({{ $prescription->dosage }})</p>
            @empty
                <p>Aucune prescription.</p>
            @endforelse
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
