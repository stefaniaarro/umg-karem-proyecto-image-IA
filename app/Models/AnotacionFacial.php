<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnotacionFacial extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anotacion_facial';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rollAngle',
        'panAngle',
        'tiltAngle',
        'detectionConfidence',
        'landmarkingConfidence',
        'joyLikelihood',
        'sorrowLikelihood',
        'angerLikelihood',
        'surpriseLikelihood',
        'underExposedLikelihood',
        'blurredLikelihood',
        'headwearLikelihood',
        'rec_id'
    ];
}
