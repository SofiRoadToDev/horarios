# POF - Plan de Ordenamiento y Funcionamiento

## Definición

El **POF (Plan de Ordenamiento y Funcionamiento)** es un informe trimestral que documenta las altas y bajas de docentes en materias y cursos específicos dentro de la institución educativa.

## Propósito

El POF define y autoriza la **relación formal** entre:
- **Docente** ↔ **Materia** ↔ **Curso**

Esta autorización es independiente de la distribución horaria específica y establece:
- Qué docente está habilitado para dictar qué materia
- En qué curso puede dictarla
- Cuántas obligaciones (bloques horarios) debe cumplir

## Características Principales

### 1. Tipo de Movimiento
- **Alta**: Incorporación de un docente a una materia/curso
- **Baja**: Desvinculación de un docente de una materia/curso

### 2. Obligaciones
- Representa la **cantidad de bloques horarios** que el docente debe dictar
- Ejemplo: 3 obligaciones = 3 bloques de 40 minutos por semana
- Los bloques pueden variar en horario exacto (Lunes 8:00 vs Miércoles 10:00) sin modificar el POF
- Lo importante es la cantidad, no la ubicación temporal

### 3. Condición del Docente
- **Titular**: Docente con titularidad en la materia
- **Interino**: Docente temporario que cubre un puesto vacante
- **Suplente**: Docente que reemplaza temporalmente a otro

### 4. Ciclo Lectivo
- El POF pertenece a un año académico específico (ej: 2025)

## Relación con Horarios

### POF ≠ Horario
- **POF**: Define QUIÉN puede enseñar QUÉ, a QUIÉNES y CUÁNTO
- **Horarios**: Define CUÁNDO y DÓNDE se dictan esos bloques

### Casos de Uso

#### Caso 1: Intercambio de Horarios
**Situación**: Dos docentes acuerdan intercambiar bloques horarios
- Docente A: Lunes 8:00 → Miércoles 10:00
- Docente B: Miércoles 10:00 → Lunes 8:00

**Resultado**:
- ✅ Se modifican los registros de `horarios` (cambian `dia_id` y `bloque_hora_id`)
- ❌ NO se modifica la tabla `pofs` (las obligaciones siguen siendo las mismas)

#### Caso 2: Baja de POF
**Situación**: Un docente se da de baja de una materia

**Resultado**:
- ✅ Se marca el POF como tipo 'Baja'
- ✅ Se eliminan todos los registros de `horarios` asociados a ese `pof_id`
- ⚠️ El sistema debe alertar sobre horarios huérfanos

#### Caso 3: Modificación de Obligaciones
**Situación**: Se reduce la carga horaria de un docente de 4 a 2 obligaciones

**Resultado**:
- ✅ Se actualiza el campo `obligaciones` en `pofs`
- ✅ Se deben eliminar 2 bloques horarios de `horarios`
- ⚠️ Validación: `COUNT(horarios WHERE pof_id = X) <= pof.obligaciones`

## Caso Especial: Mayor Jerarquía

### Contexto
Cuando un docente titular no puede dictar temporalmente, pero mantiene su titularidad por razones administrativas o de jerarquía.

### Mecánica
1. **POF del Titular**:
   - Se mantiene activo (tipo 'Alta')
   - Conserva la titularidad de la materia
   - Obligaciones = X

2. **POF del Suplente**:
   - Se da de alta provisoriamente (tipo 'Alta')
   - Condición = 'Suplente'
   - Obligaciones = X (las mismas que el titular)

3. **En el Horario**:
   - Aparecen **ambos docentes** en las celdas correspondientes
   - Formato: `"Pérez T / González S"` (Titular / Suplente)

### Implementación Futura
Para soportar este caso, se podría:
- Agregar campo `pof_suplente_id` (nullable) a tabla `horarios`
- O crear tabla intermedia `horarios_pofs` (many-to-many)
- Validar que ambos POFs correspondan al mismo curso/materia

## Validaciones Importantes

### 1. Integridad de Obligaciones
```sql
-- Cada POF debe tener al menos tantos bloques como obligaciones asignadas
SELECT pof_id, COUNT(*) as bloques_asignados
FROM horarios
GROUP BY pof_id
HAVING bloques_asignados > (SELECT obligaciones FROM pofs WHERE id = pof_id)
```

### 2. Conflictos de Horario
Un docente **no puede estar en dos cursos simultáneamente**:
```sql
-- Detectar conflictos
SELECT h1.pof_id as pof1, h2.pof_id as pof2
FROM horarios h1
JOIN horarios h2 ON h1.dia_id = h2.dia_id
    AND h1.bloque_hora_id = h2.bloque_hora_id
JOIN pofs p1 ON h1.pof_id = p1.id
JOIN pofs p2 ON h2.pof_id = p2.id
WHERE p1.docente_id = p2.docente_id
    AND p1.curso_id != p2.curso_id
```

### 3. Curso - Bloque Único
Un curso **no puede tener dos materias al mismo tiempo**:
```sql
-- Un curso solo puede tener una materia por bloque
SELECT dia_id, bloque_hora_id, COUNT(*) as materias_simultaneas
FROM horarios h
JOIN pofs p ON h.pof_id = p.id
WHERE p.curso_id = ?
GROUP BY dia_id, bloque_hora_id
HAVING materias_simultaneas > 1
```

## Flujo de Trabajo Típico

### Inicio de Trimestre
1. Se crean POFs con tipo 'Alta' para todos los docentes asignados
2. Se distribuyen las obligaciones en bloques horarios específicos
3. Se generan los registros en tabla `horarios`

### Durante el Trimestre
1. Se pueden **mover horarios** sin modificar POFs
2. Si hay baja → se marca POF como tipo 'Baja' y se eliminan horarios
3. Si hay cambio de docente → se da de baja POF antiguo y alta al nuevo

### Cierre de Trimestre
1. Los POFs tipo 'Baja' quedan registrados históricamente
2. Para el siguiente trimestre se crean nuevos POFs
3. Los horarios se pueden copiar o rediseñar según necesidad

## Resumen

El POF es el **documento administrativo** que autoriza y define la carga docente, mientras que los horarios son la **materialización operativa** de esas autorizaciones en días y bloques específicos. El POF es más estable (trimestral), los horarios son más flexibles (pueden moverse según necesidades pedagógicas).
