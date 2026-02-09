<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRepuestoRequest;
use App\Http\Requests\UpdateRepuestoRequest;
use Illuminate\Http\Request;
use App\MOdels\Repuesto;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function store(StoreRepuestoRequest $request) : JsonResponse
    {
       $repuesto = Repuesto::create($request->validated());

       return response()-> json($repuesto, 201);
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
    public function update(UpdateRepuestoRequest $request, Repuesto $repuesto) 
    {
        $repuesto->update($request->validated());

        return response() -> json($repuesto);
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
