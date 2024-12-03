<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analyse extends Model
{
  //
  protected $primaryKey = 'id_an';
  protected $fillable = ['libelle', 'result', 'date_res', 'consultation_id'];

  public $timestamps = false;
  public function consultation()
  {
    return $this->belongsTo(Consultation::class, 'consultation_id', 'id_cons');
  }
}
