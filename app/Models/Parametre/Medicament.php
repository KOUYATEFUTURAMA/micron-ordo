<?php

namespace App\Models\Parametre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    use HasFactory;

    protected $fillable = [
                'denomination',
                'composition_quantitative',
                'description',
                'numero_autorisation',
                'categorie_id',
                'sous_categorie_id',
                'forme_id',
                'emballage_id',
                'mode_administration_id',
                'image'
            ];

    public function categorie() {
        return $this->belongsTo('App\Models\Parametre\Categorie');
    }

    public function sous_categorie() {
        return $this->belongsTo('App\Models\Parametre\Categorie','sous_categorie_id');
    }

    public function forme() {
        return $this->belongsTo('App\Models\Parametre\Forme');
    }

    public function emballage() {
        return $this->belongsTo('App\Models\Parametre\Emballage');
    }

    public function mode() {
        return $this->belongsTo('App\Models\Parametre\ModeAdministration','mode_administration_id');
    }
}
