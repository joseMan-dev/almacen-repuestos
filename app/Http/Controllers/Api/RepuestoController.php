<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MOdels\Repuesto;
use Illuminate\Support\Facades\DB;

class RepuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Repuesto::orderBy('nombre')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = $request->validate([
        'referencia' => 'required|string|max:50|unique:repuestos,referencia',
        'nombre' => 'required|string|max:120',
        'descripcion' => 'nullable|string',
        'categoria' => 'nullable|string|max:80',
        'ubicacion' => 'nullable|string|max:80',
        'stock_actual' => 'nullable|integer|min:0',
        'stock_minimo' => 'nullable|integer|min:0',
       ]);
       return Repuesto::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Repuesto $repuesto)
    {
        return $repuesto;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repuesto $repuesto)
    {
        $data = $request->validate([

        'referencia' => 'required|string|max:50|unique:repuestos,referencia' . $repuesto->id,
        'nombre' => 'required|string|max:120',
        'descripcion' => 'nullable|string',
        'categoria' => 'nullable|string|max:80',
        'ubicacion' => 'nullable|string|max:80',
        'stock_actual' => 'nullable|integer|min:0',
        'stock_minimo' => 'nullable|integer|min:0',

        ]);

        $repuesto->update($data);
        return $repuesto;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repuesto $repuesto)
    {
        $repuesto->delete();
        return response()->noContent();
    }

    public function retirar(Request $request)
    {
        $data = $request->validate([
            'referencia' => ['required', 'string'],
            'cantidad' => ['required', 'integer', 'min:1'],

        ]);
        return DB::transaction(function () use ($data) {
            $repuesto = Repuesto::where('referencia', $data['referencia'])
            ->lockForUpdate()
            ->first();
        if (!$repuesto) {
            return response()->json(['message' => 'Referencia no encontrada'], 404);
        }

        if ($repuesto->stock_actual < $data['cantidad']) {
            return response()->json(['message' => 'Stock insuficiente'], 400);
            
        }

        $repuesto->decrement('stock_actual', $data['cantidad']);
        $repuesto->refresh();

        return response()->json([
            'message' => 'Retirada correcta',
            'data' => $repuesto
        ]);


        
      });
    }
}
