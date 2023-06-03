<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReconocimientoController extends Controller
{
    public function procesado()
    {
        return view('procesada', ['data' => $this->reconocimientoData(true)]);
    }


    public function historico()
    {
        return view('historico', ['data' => $this->reconocimientoData(false)]);
    }
}
