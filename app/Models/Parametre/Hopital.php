<?php

namespace App\Models\Parametre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hopital extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_hopital',
        'contact_hopital',
        'adresse_hopital',
        'localite_id',
        'contact2',
        'faxe',
        'boite_postale',
        'email',
        'logo',
        'longitude',
        'latitude',
    ];

    public function localite() {
        return $this->belongsTo('App\Models\Parametre\Localite');
    }
}
