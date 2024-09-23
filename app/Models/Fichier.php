<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichier extends Model
{
    protected $fillable = ['nom', 'chemin'];

    public function etudes()
    {
        return $this->belongsToMany(Etude::class, 'etude_fichier')->withTimestamps();
    }
}

