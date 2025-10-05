<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Collection;
use Carbon\Carbon;

class StoreRecoleccionPeligrososRequest extends FormRequest
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
            'descripcion_residuos' => 'required|string|max:1000',
            'cantidad_estimada' => 'nullable|string|max:200',
            'notas' => 'nullable|string|max:500',
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
            'descripcion_residuos.required' => 'La descripción de los residuos peligrosos es requerida.',
            'descripcion_residuos.max' => 'La descripción no puede exceder 1000 caracteres.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $userId = $this->input('user_id');
            $mesActual = Carbon::now()->month;
            $anioActual = Carbon::now()->year;

            // Validar que no exista otra solicitud de peligrosos en el mes actual
            $existeSolicitudMes = Collection::where('user_id', $userId)
                ->where('tipo_residuo', 'PELIGROSO')
                ->whereYear('created_at', $anioActual)
                ->whereMonth('created_at', $mesActual)
                ->whereIn('estado_solicitud', ['solicitado', 'aprobado', 'programado'])
                ->exists();

            if ($existeSolicitudMes) {
                $validator->errors()->add(
                    'limite_mensual',
                    'Ya tiene una solicitud de recolección de residuos peligrosos activa este mes. Solo se permite una solicitud por mes.'
                );
            }
        });
    }
}
