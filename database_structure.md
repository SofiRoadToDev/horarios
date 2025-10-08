# Estructura de Base de Datos - Sistema de Horarios

## Tablas Base

### 1. **preceptores**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| nombre | string | - |
| apellido | string | - |
| dni | string | unique |
| password | string | - |
| timestamps | - | created_at, updated_at |

---

### 2. **departamentos**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| nombre | string | unique |
| timestamps | - | created_at, updated_at |

---

### 3. **dias**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| nombre | string | - |
| timestamps | - | created_at, updated_at |

---

### 4. **bloque_horas**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| bloque | string | - |
| turno | enum | 'Mañana', 'Tarde' |
| timestamps | - | created_at, updated_at |

---

### 5. **docentes**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| nombre | string | - |
| apellido | string | - |
| dni | string | unique |
| timestamps | - | created_at, updated_at |

---

### 6. **materias**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| nombre | string | - |
| departamento_id | bigint (FK) | → departamentos.id, cascade |
| timestamps | - | created_at, updated_at |

**Relación:** Una materia pertenece a un departamento

---

### 7. **cursos**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| codigo | string | unique |
| ciclo | enum | 'Básico', 'Superior' |
| turno | enum | 'Mañana', 'Tarde' |
| preceptor_id | bigint (FK) | → preceptores.id, cascade |
| timestamps | - | created_at, updated_at |

**Relación:** Un curso tiene un preceptor asignado

---

## Tablas de Relación (Pivot)

### 8. **cursos_materias**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| curso_id | bigint (FK) | → cursos.id, cascade |
| materia_id | bigint (FK) | → materias.id, cascade |
| timestamps | - | created_at, updated_at |

**Relación:** Many-to-Many entre Cursos y Materias

---

### 9. **docentes_materias**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| docente_id | bigint (FK) | → docentes.id, cascade |
| materia_id | bigint (FK) | → materias.id, cascade |
| timestamps | - | created_at, updated_at |

**Relación:** Many-to-Many entre Docentes y Materias

---

## Tablas Principales del Sistema

### 10. **pofs** (Plan de Ordenamiento y Funcionamiento)
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| tipo | enum | 'Alta', 'Baja' |
| docente_id | bigint (FK) | → docentes.id, cascade |
| materia_id | bigint (FK) | → materias.id, cascade |
| curso_id | bigint (FK) | → cursos.id, cascade |
| condicion_docente | enum | 'Titular', 'Interino', 'Suplente' |
| ciclo_lectivo | date | - |
| fecha | date | - |
| obligaciones | integer | Cantidad de horas cátedra (40 min c/u) |
| causal | enum | 'Jubilacion', 'Fallecimiento', 'Lic.art.24', 'cargo_mayor_jearquia', 'Renuncia' |
| instrumento_legal | string | - |
| observaciones | string | - |
| timestamps | - | created_at, updated_at |

**Descripción:** Registra las altas y bajas de docentes en materias y cursos específicos. Cada bloque horario representa una obligación.

---

### 11. **horarios**
| Campo | Tipo | Restricciones |
|-------|------|---------------|
| id | bigint (PK) | auto_increment |
| docente_id | bigint (FK) | → docentes.id, cascade |
| curso_id | bigint (FK) | → cursos.id, cascade |
| materia_id | bigint (FK) | → materias.id, cascade |
| dia_id | bigint (FK) | → dias.id, cascade |
| bloque_hora_id | bigint (FK) | → bloque_horas.id, cascade |
| ciclo_lectivo | year | - |
| pof_id | bigint (FK) | → pofs.id, cascade, **nullable** |
| condicion_docente | enum | 'Titular', 'Interino', 'Suplente' |
| timestamps | - | created_at, updated_at |

**Descripción:** Tabla principal que registra la asignación de horarios. Vincula docentes, cursos, materias, días y bloques horarios con el POF correspondiente (opcional).

---

## Dependencias para Crear Horarios

Para crear un registro en la tabla `horarios` se requieren datos en:

✅ **Tablas Base (ya pobladas):**
- dias (5 registros)
- departamentos (3 registros)
- docentes (3 registros)
- cursos (5 registros)
- bloque_horas (8 registros)
- materias (4 registros)

⚠️ **Tabla Opcional:**
- **pofs** (0 registros) - **OPCIONAL** (campo nullable) - Se puede crear horarios sin POF si es necesario

---

## Diagrama de Relaciones

```
departamentos
    ↓ (1:N)
materias ←→ (N:M) → docentes
    ↓ (N:M)
cursos ← (N:1) → preceptores

pofs (requiere: docente + materia + curso)
    ↓ (1:N)
horarios (requiere: pof + docente + curso + materia + dia + bloque_hora)
```

---

## Notas Importantes

1. **POFs**: Deben crearse antes de los horarios. Representan la autorización administrativa para que un docente dicte una materia en un curso específico.

2. **Obligaciones**: En la tabla `pofs`, el campo `obligaciones` indica cuántas horas cátedra tiene asignado el docente. Cada bloque horario equivale a una obligación.

3. **Condición Docente**: Puede ser Titular, Interino o Suplente (presente tanto en `pofs` como en `horarios`).

4. **Cascadas**: Todas las relaciones tienen `onDelete('cascade')`, por lo que eliminar un registro padre eliminará los hijos automáticamente.
