<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
  //
  public function appointments()
  {
    return $this->hasMany(Appoint::class);
  }

}
