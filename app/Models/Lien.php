<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Etude;

class Lien extends Model
{
    use HasFactory;

    protected $fillable = ['etude_id', 'link_name', 'link_url', 'position'];

    public function etude()
    {
        return $this->belongsTo(Etude::class);
    }
}
