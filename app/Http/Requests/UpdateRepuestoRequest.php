<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepuestoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'referencia' => 'required|string|max:50|unique:repuestos,referencia,'. $this->route('repuesto')->id,
            'nombre' => 'required|string|max:120',
            'description' => 'nullable|string',
            'categoria' => 'nullable|string|max:80',
            'ubicacion' => 'nullable|string|max:80',
            'stock_actual' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
        ];
    }
}
