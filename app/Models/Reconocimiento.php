<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reconocimiento extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reconocimiento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imagen',
        'cloud_storage',
        'bitbuket',
        'user_id'
    ];

    public function usuario()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function facial()
    {
        return $this->hasMany(AnotacionFacial::class, "rec_id", "id");
    }

    public function logo()
    {
        return $this->hasMany(AnotacionLogo::class, "rec_id", "id");
    }

    public function etiqueta()
    {
        return $this->hasMany(AnotacionEtiqueta::class, "rec_id", "id");
    }

    public function propiedad()
    {
        return $this->hasMany(AnotacionImagenPropiedad::class, "rec_id", "id");
    }

    public function seguridad()
    {
        return $this->hasMany(AnotacionSeguridad::class, "rec_id", "id");
    }

    public function web_entidad()
    {
        return $this->hasMany(WebEntidad::class, "rec_id", "id");
    }

    public function web_conincidencia()
    {
        return $this->hasMany(WebCoincidencia::class, "rec_id", "id");
    }

    public function web_pagina()
    {
        return $this->hasMany(WebPaginaCoincidencia::class, "rec_id", "id");
    }

    public function web_similar()
    {
        return $this->hasMany(WebSimilar::class, "rec_id", "id");
    }

    public function web_etiqueta()
    {
        return $this->hasMany(WebEtiqueta::class, "rec_id", "id");
    }
}
