<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  //
  protected $primaryKey = 'id_serv';
  protected $fillable = ['serv_name', 'description'];
  public function doctors()
  {
    return $this->hasMany(Doctor::class);
  }

  public function appoints()
  {
    return $this->hasMany(Appoint::class, 'service_id', 'id_serv');
  }


}
