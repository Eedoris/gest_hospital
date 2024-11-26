<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
  //
  protected $primaryKey = 'id_doctor';
  protected $table = 'doctors';

  protected $fillable = [
    'doctor_title',
    'specialty',
    'user_id',
    'id_serv',
    'id_spe',
  ];
  public function user()
  {
    return $this->belongsTo(Users::class, 'user_id', 'id_user');
  }


  public function service()
  {
    return $this->belongsTo(Service::class, 'id_serv', 'id_serv');
  }

  public function speciality()
  {
    return $this->belongsTo(Speciality::class, 'id_spe', 'id_spe');
  }

  public function consultations()
  {
    return $this->hasMany(Consultation::class, 'doctor_id', 'id_doctor');
  }

  public function appointments()
  {
    return $this->hasMany(Appoint::class);
  }

}
