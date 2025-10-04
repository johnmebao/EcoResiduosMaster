
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Collection;

class StoreRecoleccionOrganicosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'localidad_id' => 'required|exists:localidads,id',
            'notas' => 'nullable|string|max:500',
            // NO se permite fecha_programada - se asigna automáticamente
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'El usuario es requerido.',
            'user_id.exists' => 'El usuario no existe.',
            'company_id.required' => 'La empresa es requerida.',
            'company_id.exists' => 'La empresa no existe.',
            'localidad_id.required' => 'La localidad es requerida.',
            'localidad_id.exists' => 'La localidad no existe.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar que no exista una recolección orgánica programada para esta semana
            $userId = $this->input('user_id');
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            $existeRecoleccion = Collection::where('user_id', $userId)
                ->where('tipo_residuo', 'FO') // Fracción Orgánica
                ->whereBetween('fecha_programada', [$startOfWeek, $endOfWeek])
                ->whereIn('estado', ['pendiente', 'programada'])
                ->exists();

            if ($existeRecoleccion) {
                $validator->errors()->add(
                    'duplicado',
                    'Ya existe una recolección de orgánicos programada para esta semana.'
                );
            }
        });
    }
}
