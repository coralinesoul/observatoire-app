<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Source;
use \App\Models\Theme;
use \App\Models\Lien;

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
}
