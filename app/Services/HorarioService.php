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
     * @param array $data Array asociativo con los datos del horario (pof_id, dia_id, bloque_hora_id).
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
            'pof_id' => ['required', 'exists:pofs,id'],
            'dia_id' => ['required', 'exists:dias,id'],
            'bloque_hora_id' => ['required', 'exists:bloque_horas,id'],
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
        // Obtener el POF para saber el curso
        $pof = \App\Models\Pof::find($data['pof_id']);

        if (!$pof) {
            throw ValidationException::withMessages([
                'pof_id' => 'El POF especificado no existe.'
            ]);
        }

        // Verificar si ya existe un horario para este curso en el mismo día y bloque
        $query = Horario::whereHas('pof', function($q) use ($pof) {
                            $q->where('curso_id', $pof->curso_id);
                        })
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

        // Verificar conflicto de docente (no puede estar en 2 cursos al mismo tiempo)
        $conflictoDocente = Horario::whereHas('pof', function($q) use ($pof) {
                                        $q->where('docente_id', $pof->docente_id)
                                          ->where('curso_id', '!=', $pof->curso_id);
                                    })
                                    ->where('dia_id', $data['dia_id'])
                                    ->where('bloque_hora_id', $data['bloque_hora_id']);

        if ($excludeHorarioId) {
            $conflictoDocente->where('id', '!=', $excludeHorarioId);
        }

        if ($conflictoDocente->exists()) {
            throw ValidationException::withMessages([
                'conflicto_docente' => 'El docente ya tiene asignado otro curso en este mismo horario.'
            ]);
        }
    }
}
