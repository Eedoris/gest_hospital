<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
  //
  protected $primaryKey = 'id_pres';
  protected $fillable = ['product', 'dosage'];
  public function consultation()
  {
    return $this->belongsTo(Consultation::class);
  }

}
