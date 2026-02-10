<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetirarRepuestoRequest extends FormRequest
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
            'referencia' => ['required', 'string', 'max:50'],
            'cantidad' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'referencia.required' => 'La referencia es obligatoria.',
            'referencia.max' => 'L referencia no puede superar los 50 caracteres.',
            'cantidad.required' => 'La cantidad es obligatoria',
            'cantidad.integer' => 'La cantidad debe ser un numero entero',
            'cantidad.min' => 'La cantidad mínima para retirar es 1.',
        ];
    }
}
