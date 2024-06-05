<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable =['nom','prenom','mail','diffusion_mail'];

    public function etudes() {
        return $this->belongsToMany(Etude::class);
    }
}
