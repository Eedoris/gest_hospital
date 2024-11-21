<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyseDisponible extends Model
{
  use HasFactory;

  protected $table = 'analyses_disponibles';
  protected $fillable = ['libelle'];
}
