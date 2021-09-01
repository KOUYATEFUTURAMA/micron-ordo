<?php

namespace App\Models\Application;

use App\Models\User;
use App\Models\Parametre\Localite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medecin extends Model
{
    use SoftDeletes;

    protected $fillable = [
                            'nom',
                            'contact',
                            'email',
                            'localite_id',
                            'hopitaux',
                            'specialites',
                            'updated_by',
                            'deleted_by',
                            'created_by'
                          ];

    protected $dates = ['deleted_at','date_naissance'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'hopitaux' => 'array',
        'specialites' => 'array',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the localite that owns the phone.
     */
    public function localite()
    {
        return $this->belongsTo(Localite::class);
    }
}
