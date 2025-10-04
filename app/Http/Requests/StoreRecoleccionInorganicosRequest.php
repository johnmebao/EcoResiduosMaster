
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Collection;
use Carbon\Carbon;

class StoreRecoleccionInorganicosRequest extends FormRequest
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
            'ruta_id' => 'nullable|exists:rutas,id',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'tipo_recoleccion' => 'required|in:programada,demanda',
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
            'ruta_id.exists' => 'La ruta no existe.',
            'fecha_programada.required' => 'La fecha programada es requerida.',
            'fecha_programada.date' => 'La fecha programada debe ser una fecha válida.',
            'fecha_programada.after_or_equal' => 'La fecha programada debe ser hoy o posterior.',
            'tipo_recoleccion.required' => 'El tipo de recolección es requerido.',
            'tipo_recoleccion.in' => 'El tipo de recolección debe ser programada o por demanda.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $userId = $this->input('user_id');
            $fechaProgramada = Carbon::parse($this->input('fecha_programada'));
            $tipoRecoleccion = $this->input('tipo_recoleccion');

            // Validar frecuencia: máximo 2 veces por semana para programadas
            if ($tipoRecoleccion === 'programada') {
                $startOfWeek = $fechaProgramada->copy()->startOfWeek();
                $endOfWeek = $fechaProgramada->copy()->endOfWeek();

                $recoleccionesSemana = Collection::where('user_id', $userId)
                    ->where('tipo_residuo', 'INORGANICO')
                    ->whereBetween('fecha_programada', [$startOfWeek, $endOfWeek])
                    ->whereIn('estado', ['pendiente', 'programada'])
                    ->count();

                if ($recoleccionesSemana >= 2) {
                    $validator->errors()->add(
                        'frecuencia',
                        'Ya tiene 2 recolecciones de inorgánicos programadas esta semana. Máximo permitido: 2 por semana.'
                    );
                }
            }

            // Validar que no exista duplicado en la misma fecha
            $existeDuplicado = Collection::where('user_id', $userId)
                ->where('tipo_residuo', 'INORGANICO')
                ->whereDate('fecha_programada', $fechaProgramada)
                ->whereIn('estado', ['pendiente', 'programada'])
                ->exists();

            if ($existeDuplicado) {
                $validator->errors()->add(
                    'duplicado',
                    'Ya existe una recolección de inorgánicos programada para esta fecha.'
                );
            }
        });
    }
}
