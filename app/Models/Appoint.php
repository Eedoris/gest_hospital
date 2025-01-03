<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appoint extends Model
{
  //

  protected $primaryKey = 'id_appoint';
  public $timestamps = false;

  protected $fillable = ['name', 'surname', 'contact', 'date_app', 'time_app', 'service_id', 'status'];

  protected $casts = [
    'date_app' => 'datetime',
  ];


  public function user()
  {
    return $this->belongsTo(Users::class);
  }

  public function doctor()
  {
    return $this->belongsTo(Doctor::class);
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function service()
  {
    return $this->belongsTo(Service::class, 'service_id', 'id_serv');
  }

}
