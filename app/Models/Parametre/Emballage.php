<?php

namespace App\Models\Parametre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emballage extends Model
{
    use HasFactory;

    protected $fillable = ['libelle_emballage'];
}
