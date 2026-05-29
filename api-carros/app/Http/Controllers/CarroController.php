<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public function index()
    {
        return response()->json([
            'ok' => true,
            'data' => Carro::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'placas' => 'required|max:20',
            'serie' => 'required|max:50',
            'color' => 'nullable|max:30',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $rutaFoto = null;

        if ($request->hasFile('foto')) {
            $rutaFoto = $request->file('foto')
                                ->store('carros', 'public');
        }

        $carro = Carro::create([
            'placas' => $request->placas,
            'serie' => $request->serie,
            'color' => $request->color,
            'foto' => $rutaFoto
        ]);

        return response()->json([
            'ok' => true,
            'mensaje' => 'Carro creado correctamente',
            'data' => $carro
        ], 201);
    }

    public function show(string $id)
    {
        $carro = Carro::find($id);

        if (!$carro) {
            return response()->json([
                'ok' => false,
                'error' => 'Carro no encontrado'
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'data' => $carro
        ]);
    }

    public function update(Request $request, string $id)
    {
        $carro = Carro::find($id);

        if (!$carro) {
            return response()->json([
                'ok' => false,
                'error' => 'Carro no encontrado'
            ], 404);
        }

        $request->validate([
            'placas' => 'required|max:20',
            'serie' => 'required|max:50',
            'color' => 'nullable|max:30',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $carro->foto = $request->file('foto')
                                   ->store('carros', 'public');
        }

        $carro->placas = $request->placas;
        $carro->serie = $request->serie;
        $carro->color = $request->color;

        $carro->save();

        return response()->json([
            'ok' => true,
            'mensaje' => 'Carro actualizado correctamente',
            'data' => $carro
        ]);
    }

    public function destroy(string $id)
    {
        $carro = Carro::find($id);

        if (!$carro) {
            return response()->json([
                'ok' => false,
                'error' => 'Carro no encontrado'
            ], 404);
        }

        $carro->delete();

        return response()->json([
            'ok' => true,
            'mensaje' => 'Carro eliminado correctamente'
        ]);
    }
}