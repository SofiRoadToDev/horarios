<?php

namespace App\Services;

use App\Models\Horario;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class HorarioService
{
    /**
     * Crea un nuevo registro de horario en la base de datos.
     *
     * @param array $data Array asociativo con los datos del horario (docente_id, curso_id, materia_id, dia_id, bloque_hora_id, ciclo_lectivo, condicion_docente).
     * @return Horario El objeto Horario recién creado.
     * @throws ValidationException Si los datos no son válidos o el bloque horario ya está ocupado.
     */
    public function createHorario(array $data): Horario
    {
        // 1. Valida que los datos básicos sean correctos y existan las FK.
        $this->validateHorarioData($data);

        // 2. Verifica que el bloque horario no esté ya ocupado para el curso.
        $this->checkAvailability($data);

        // 3. Crea el registro de horario.
        return Horario::create($data);
    }

    /**
     * Actualiza un registro de horario existente.
     *
     * @param Horario $horario El objeto Horario a actualizar.
     * @param array $data Array asociativo con los nuevos datos del horario.
     * @return Horario El objeto Horario actualizado.
     * @throws ValidationException Si los datos no son válidos o el bloque horario ya está ocupado por otro registro.
     */
    public function updateHorario(Horario $horario, array $data): Horario
    {
        // 1. Valida que los datos básicos sean correctos y existan las FK.
        $this->validateHorarioData($data);

        // 2. Verifica que el bloque horario no esté ya ocupado para el curso, excluyendo el horario actual.
        $this->checkAvailability($data, $horario->id);

        // 3. Actualiza el registro de horario.
        $horario->update($data);
        return $horario;
    }

    /**
     * Elimina un registro de horario.
     *
     * @param Horario $horario El objeto Horario a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deleteHorario(Horario $horario): bool
    {
        return $horario->delete();
    }

    /**
     * Valida los datos proporcionados para la creación o actualización de un horario.
     *
     * @param array $data
     * @throws ValidationException Si la validación falla.
     */
    protected function validateHorarioData(array $data): void
    {
        $validator = Validator::make($data, [
            'docente_id' => ['required', 'exists:docentes,id'],
            'curso_id' => ['required', 'exists:cursos,id'],
            'materia_id' => ['required', 'exists:materias,id'],
            'dia_id' => ['required', 'exists:dias,id'],
            'bloque_hora_id' => ['required', 'exists:bloque_horas,id'],
            'ciclo_lectivo' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'condicion_docente' => ['required', 'in:Titular,Interino,Suplente'],
        ]);

        $validator->validate(); // Lanza ValidationException si falla
    }

    /**
     * Verifica si el bloque horario ya está ocupado para un curso específico.
     *
     * @param array $data Datos del horario a verificar.
     * @param int|null $excludeHorarioId ID de un horario a excluir de la verificación (útil para actualizaciones).
     * @throws ValidationException Si el bloque horario ya está ocupado.
     */
    protected function checkAvailability(array $data, ?int $excludeHorarioId = null): void
    {
        $query = Horario::where('curso_id', $data['curso_id'])
                        ->where('dia_id', $data['dia_id'])
                        ->where('bloque_hora_id', $data['bloque_hora_id']);

        if ($excludeHorarioId) {
            $query->where('id', '!=', $excludeHorarioId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'bloque_horario' => 'Este bloque horario ya está ocupado para este curso.'
            ]);
        }
    }
}
