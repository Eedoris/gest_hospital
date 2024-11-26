<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
  //
  protected $primaryKey = 'id_cons';
  protected $fillable = ['patient_id', 'date_cons', 'note', 'doctor_id'];
  public function doctor()
  {
    return $this->belongsTo(Doctor::class, 'doctor_id', 'id_doctor');
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'id_pat');
  }

  public function prescriptions()
  {
    return $this->hasMany(Prescription::class);
  }

  public function analyses()
  {
    return $this->hasMany(Analyse::class, 'consultation_id', 'id_cons');
  }
}
