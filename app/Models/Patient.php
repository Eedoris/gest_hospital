<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
  //
  protected $primaryKey = 'id_pat';

  protected $fillable = ['name', 'surname', 'contact', 'date_of_birth', 'sex', 'adress', 'uuid'];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($patient) {
      $patient->uuid = (string) Str::uuid();
    });
  }


  public function consultations()
  {
    return $this->hasMany(Consultation::class);
  }

  public function appointment()
  {
    return $this->hasOne(Appoint::class);
  }

}
