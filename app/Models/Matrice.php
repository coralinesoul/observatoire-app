<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrice extends Model
{
    protected $fillable = ['name', 'groupe', 'categorie'];

    use HasFactory;

    public function etudes() {
        return $this->belongsToMany(Etude::class);
    }
    public function themes() {
        return $this->belongsToMany(Theme::class);
    }
}
