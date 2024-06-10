<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Source;
use \App\Models\Theme;
use \App\Models\Lien;
use \App\Models\Contact;
use \App\Models\Zone;
use \App\Models\Type;
use \App\Models\Parametre;
use \App\Models\Matrice;

/**
 * @mixin IdeHelperEtude
 */
class Etude extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'resume',
        'longtitle',
        'active',
        'reglementaire',
        'startyear',
        'stopyear',
        'frequence',
    ];
    public function sources() {
        return $this->belongsToMany(Source::class);
    }
    public function themes() {
        return $this->belongsToMany(Theme::class);
    }
    public function liens() {
        return $this->hasMany(Lien::class);
    }
    public function zones() {
        return $this->belongsToMany(Zone::class);
    }
    public function types() {
        return $this->belongsToMany(Type::class);
    }
    public function contacts() {
        return $this->belongsToMany(Contact::class);
    }
    public function parametres() {
        return $this->belongsToMany(Parametre::class);
    }
    public function matrices() {
        return $this->belongsToMany(Matrice::class);
    }
}