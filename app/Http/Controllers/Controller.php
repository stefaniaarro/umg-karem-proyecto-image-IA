<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Reconocimiento;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadFile(UploadedFile $file, $folder = null, $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        return $file->storeAs(
            $folder,
            $name . "." . $file->getClientOriginalExtension(),
            'gcs'
        );
    }

    public function registerBitacora(string $tracer, string $metadata)
    {
        Bitacora::create([
            "tracer" => $tracer,
            "metadata" => $metadata,
            "user_id" => Auth::user()->id
        ]);
    }

    public function probabilidadText($key)
    {
        $probabilidades = [
            "VERY_LIKELY" => "MUY PROBABLE",
            "LIKELY" => "PROBABLE",
            "POSSIBLE" => "POSIBLE",
            "VERY_UNLIKELY" => "MUY POSIBLE",
            "UNLIKELY" => "IMPOSIBLE"
        ];

        return $probabilidades[$key] ?? "N/A";
    }

    public function reconocimientoData(bool $limit)
    {
        return Reconocimiento::with([
            'usuario',
            'facial',
            'logo',
            'etiqueta',
            'propiedad',
            'seguridad',
            'web_entidad',
            'web_conincidencia',
            'web_pagina',
            'web_similar',
            'web_etiqueta'
        ])
            ->when($limit, function ($query) {
                return $query->limit(10)
                    ->orderByDesc('id');
            })
            ->get();
    }
}
