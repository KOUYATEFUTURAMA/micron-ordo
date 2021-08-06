<?php

namespace App\Models\Parametre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_pharmacie',
        'contact_pharmacie',
        'responsable',
        'contact_responsable',
        'adresse_pharmacie',
        'contact2',
        'faxe',
        'boite_postale',
        'email',
        'longitude',
        'latitude',
        'logo',
        'localite_id',
    ];

    public function localite() {
        return $this->belongsTo('App\Models\Parametre\Localite');
    }

}
