<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Etude;
use \App\Models\Parametre;
use \App\Models\Matrice;

class Theme extends Model
{
    use HasFactory;

    protected $fillable =['name'];

    public function etudes() {
        return $this->belongsToMany(Etude::class);
    }
    public function parametres() {
        return $this->belongsToMany(Parametre::class);
    }
    public function matrices() {
        return $this->belongsToMany(Matrice::class);
    }
}
