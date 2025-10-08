import { useState, useEffect } from 'react';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Loader2 } from 'lucide-react';

interface Materia {
    id: number;
    nombre: string;
}

interface Docente {
    id: number;
    nombre: string;
    materias: Materia[];
}

interface HorarioModalProps {
    open: boolean;
    onClose: () => void;
    onSave: (data: HorarioFormData) => Promise<void>;
    docentes: Docente[];
    condicionesDocente: string[];
    cursoId: number;
    diaId: number;
    bloqueHoraId: number;
    diaNombre: string;
    bloqueHoraNombre: string;
}

export interface HorarioFormData {
    curso_id: number;
    dia_id: number;
    bloque_hora_id: number;
    docente_id: number | null;
    materia_id: number | null;
    condicion_docente: string | null;
    ciclo_lectivo: number;
}

export default function HorarioModal({
    open,
    onClose,
    onSave,
    docentes,
    condicionesDocente,
    cursoId,
    diaId,
    bloqueHoraId,
    diaNombre,
    bloqueHoraNombre,
}: HorarioModalProps) {
    const [formData, setFormData] = useState<HorarioFormData>({
        curso_id: cursoId,
        dia_id: diaId,
        bloque_hora_id: bloqueHoraId,
        docente_id: null,
        materia_id: null,
        condicion_docente: null,
        ciclo_lectivo: new Date().getFullYear(),
    });

    const [materiasDisponibles, setMateriasDisponibles] = useState<Materia[]>(
        [],
    );
    const [isSubmitting, setIsSubmitting] = useState(false);

    // Resetear form cuando cambian los props
    useEffect(() => {
        setFormData({
            curso_id: cursoId,
            dia_id: diaId,
            bloque_hora_id: bloqueHoraId,
            docente_id: null,
            materia_id: null,
            condicion_docente: null,
            ciclo_lectivo: new Date().getFullYear(),
        });
        setMateriasDisponibles([]);
    }, [cursoId, diaId, bloqueHoraId, open]);

    // Cuando selecciona docente, actualizar materias disponibles
    const handleDocenteChange = (docenteId: string) => {
        const docente = docentes.find((d) => d.id === parseInt(docenteId));
        setFormData({
            ...formData,
            docente_id: parseInt(docenteId),
            materia_id: null, // Reset materia
        });
        setMateriasDisponibles(docente?.materias || []);
    };

    const handleSubmit = async () => {
        if (
            !formData.docente_id ||
            !formData.materia_id ||
            !formData.condicion_docente
        ) {
            alert('Por favor complete todos los campos');
            return;
        }

        setIsSubmitting(true);
        try {
            await onSave(formData);
            onClose();
        } catch (error) {
            console.error('Error guardando horario:', error);
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <Dialog open={open} onOpenChange={onClose}>
            <DialogContent className="sm:max-w-[500px]">
                <DialogHeader>
                    <DialogTitle>Agregar Horario</DialogTitle>
                    <DialogDescription>
                        {diaNombre} - {bloqueHoraNombre}
                    </DialogDescription>
                </DialogHeader>

                <div className="grid gap-4 py-4">
                    {/* Selector de Docente */}
                    <div className="grid gap-2">
                        <Label htmlFor="docente">Docente</Label>
                        <Select
                            value={formData.docente_id?.toString() || ''}
                            onValueChange={handleDocenteChange}
                        >
                            <SelectTrigger id="docente">
                                <SelectValue placeholder="Seleccione un docente" />
                            </SelectTrigger>
                            <SelectContent>
                                {docentes.map((docente) => (
                                    <SelectItem
                                        key={docente.id}
                                        value={docente.id.toString()}
                                    >
                                        {docente.nombre}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>

                    {/* Selector de Materia */}
                    <div className="grid gap-2">
                        <Label htmlFor="materia">Materia</Label>
                        <Select
                            value={formData.materia_id?.toString() || ''}
                            onValueChange={(value) =>
                                setFormData({
                                    ...formData,
                                    materia_id: parseInt(value),
                                })
                            }
                            disabled={!formData.docente_id}
                        >
                            <SelectTrigger id="materia">
                                <SelectValue
                                    placeholder={
                                        formData.docente_id
                                            ? 'Seleccione una materia'
                                            : 'Primero seleccione un docente'
                                    }
                                />
                            </SelectTrigger>
                            <SelectContent>
                                {materiasDisponibles.length > 0 ? (
                                    materiasDisponibles.map((materia) => (
                                        <SelectItem
                                            key={materia.id}
                                            value={materia.id.toString()}
                                        >
                                            {materia.nombre}
                                        </SelectItem>
                                    ))
                                ) : (
                                    <SelectItem value="none" disabled>
                                        No hay materias disponibles
                                    </SelectItem>
                                )}
                            </SelectContent>
                        </Select>
                        {formData.docente_id &&
                            materiasDisponibles.length === 0 && (
                                <p className="text-sm text-muted-foreground">
                                    Este docente no tiene materias asignadas
                                </p>
                            )}
                    </div>

                    {/* Selector de Condición */}
                    <div className="grid gap-2">
                        <Label htmlFor="condicion">Condición</Label>
                        <Select
                            value={formData.condicion_docente || ''}
                            onValueChange={(value) =>
                                setFormData({
                                    ...formData,
                                    condicion_docente: value,
                                })
                            }
                        >
                            <SelectTrigger id="condicion">
                                <SelectValue placeholder="Seleccione la condición" />
                            </SelectTrigger>
                            <SelectContent>
                                {condicionesDocente.map((condicion) => (
                                    <SelectItem key={condicion} value={condicion}>
                                        {condicion}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="outline"
                        onClick={onClose}
                        disabled={isSubmitting}
                    >
                        Cancelar
                    </Button>
                    <Button
                        type="button"
                        onClick={handleSubmit}
                        disabled={isSubmitting}
                    >
                        {isSubmitting ? (
                            <>
                                <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                                Guardando...
                            </>
                        ) : (
                            'Guardar'
                        )}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
