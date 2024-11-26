<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Users extends Authenticatable
{
  use HasFactory;

  // Spécifier que la clé primaire est 'id_user'
  protected $primaryKey = 'id_user';

  // Indiquer que la clé n'est pas auto-incrémentée si elle utilise un UUID
  public $incrementing = true; // Si c'est un UUID, mets `false`

  // Type de clé primaire
  protected $keyType = 'int'; // Ou 'string' si c'est un UUID

  // Champs massivement assignables
  protected $fillable = ['name', 'surname', 'email', 'password', 'statut', 'uuid'];

  // Génération automatique d'UUID pour chaque création d'utilisateur

}
