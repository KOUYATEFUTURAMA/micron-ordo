<?php

namespace App\Models\Parametre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

   protected $fillable = ['libelle_categorie','categorie_id'];

   public function categorie() {
        return $this->belongsTo('App\Models\Parametre\Categorie','categorie_id');
   }
}
