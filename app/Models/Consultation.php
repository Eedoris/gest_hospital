<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
  //
  protected $primaryKey = 'id_cons';
  protected $fillable = ['date_cons', 'note', 'doctor_id', 'patient_id'];

  public function doctor()
  {
    return $this->belongsTo(Doctor::class, 'doctor_id', 'id_doctor');
  }

  // Dans le modèle Consultation
  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'id_pat');
  }


  public function analyses()
  {
    return $this->hasMany(Analyse::class, 'consultation_id', 'id_cons');
  }

  public function prescriptions()
  {
    return $this->hasMany(Prescription::class, 'consultation_id', 'id_cons');
  }
}
