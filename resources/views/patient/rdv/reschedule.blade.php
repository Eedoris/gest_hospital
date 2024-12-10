@extends('layouts/sreach')

@section('content')
    <div class="container">
        <h2>Reprogrammer le rendez-vous</h2>
        <form action="{{ route('appoint.reschedule') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="date_app" class="form-label">Nouvelle date</label>
                <input type="date" class="form-control" id="date_app" name="date_app" min="{{ date('Y-m-d') }}"
                    value="{{ old('date_app') }}" required>
            </div>

            <div class="mb-3">
                <label for="time_app" class="form-label">Nouvelle heure</label>
                <input type="time" class="form-control" id="time_app" name="time_app" value="{{ old('time_app') }}"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Reprogrammer</button>
            <a href="{{ route('appointindex') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
