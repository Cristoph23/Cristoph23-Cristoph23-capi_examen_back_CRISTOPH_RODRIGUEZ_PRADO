<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edadCalcular($fecha_nacimiento)
    {
        [$año,$mes,$dia] = explode("-",$fecha_nacimiento);
        $año_diferencia  = date("Y") - $año;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 && $mes_diferencia < 0){
            $año_diferencia--;
        }
        return $año_diferencia;
    }

    public function index()
    {
        $users = User::query()->with('userdomicilio')->get();
        $add_edad = $users->each(function ($item){
            $item->edad = $this->edadCalcular($item->fecha_nacimiento);
        });

        return response()->json($add_edad);
    }
}
