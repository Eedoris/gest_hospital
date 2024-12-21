<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;


class Users extends Authenticatable
{
  use HasFactory;


  protected $primaryKey = 'id_user';

  public $incrementing = true;

  protected $keyType = 'int';

  protected $fillable = ['name', 'surname', 'email', 'password', 'statut', 'uuid'];

  // Rôles disponibles
  const ROLE_ADMIN = 'admin';
  const ROLE_DOCTOR = 'docteur';
  const ROLE_SECRETAIRE = 'secretaire';
  const ROLE_GESTIONNAIRE = 'gestionnaire';

  // Vérification de rôle
  public function hasRole($role)
  {
    return $this->statut === $role;
  }

  public function doctor()
  {
    return $this->hasOne(Doctor::class, 'user_id', 'id_user');
  }


  // Dans le modèle User

  // // public function hasAnyRole(array $roles)
  // {
  //   return in_array($this->statut, $roles);
  // }


}
