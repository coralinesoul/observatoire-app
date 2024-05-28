<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Etude;

class Source extends Model
{
    use HasFactory;

    protected $fillable =['name'];

    public function etudes() {
        return $this->belongsToMany(Etude::class);
    }

}
