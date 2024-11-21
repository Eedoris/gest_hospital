<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
  //
  protected $fillable = ['doctor_title'];
  public function service()
  {
    return $this->belongsTo(Service::class);
  }

  public function speciality()
  {
    return $this->belongsTo(Speciality::class);
  }

  public function consultations()
  {
    return $this->hasMany(Consultation::class);
  }

  public function appointments()
  {
    return $this->hasMany(Appoint::class);
  }

}
