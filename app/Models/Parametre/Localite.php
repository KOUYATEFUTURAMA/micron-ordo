<?php

namespace App\Models\Parametre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localite extends Model
{
    use HasFactory;

    protected $fillable = ['libelle_localite'];
}
