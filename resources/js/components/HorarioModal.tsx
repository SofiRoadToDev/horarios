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

interface Pof {
    id: number;
    docente: string;
    materia: string;
    condicion_docente: string;
    obligaciones: number;
}

interface HorarioModalProps {
    open: boolean;
    onClose: () => void;
    onSave: (data: HorarioFormData) => Promise<void>;
    pofs: Pof[];
    diaId: number;
    bloqueHoraId: number;
    diaNombre: string;
    bloqueHoraNombre: string;
}

export interface HorarioFormData {
    pof_id: number | null;
    dia_id: number;
    bloque_hora_id: number;
}

export default function HorarioModal({
    open,
    onClose,
    onSave,
    pofs,
    diaId,
    bloqueHoraId,
    diaNombre,
    bloqueHoraNombre,
}: HorarioModalProps) {
    const [formData, setFormData] = useState<HorarioFormData>({
        pof_id: null,
        dia_id: diaId,
        bloque_hora_id: bloqueHoraId,
    });

    const [isSubmitting, setIsSubmitting] = useState(false);

    // Resetear form cuando cambian los props
    useEffect(() => {
        setFormData({
            pof_id: null,
            dia_id: diaId,
            bloque_hora_id: bloqueHoraId,
        });
    }, [diaId, bloqueHoraId, open]);

    const handleSubmit = async () => {
        if (!formData.pof_id) {
            alert('Por favor seleccione un POF');
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

    const selectedPof = pofs.find((p) => p.id === formData.pof_id);

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
                    {/* Selector de POF */}
                    <div className="grid gap-2">
                        <Label htmlFor="pof">
                            Seleccione Docente y Materia (POF)
                        </Label>
                        <Select
                            value={formData.pof_id?.toString() || ''}
                            onValueChange={(value) =>
                                setFormData({
                                    ...formData,
                                    pof_id: parseInt(value),
                                })
                            }
                        >
                            <SelectTrigger id="pof">
                                <SelectValue placeholder="Seleccione un POF" />
                            </SelectTrigger>
                            <SelectContent>
                                {pofs.length > 0 ? (
                                    pofs.map((pof) => (
                                        <SelectItem
                                            key={pof.id}
                                            value={pof.id.toString()}
                                        >
                                            {pof.docente} - {pof.materia} (
                                            {pof.condicion_docente})
                                        </SelectItem>
                                    ))
                                ) : (
                                    <SelectItem value="none" disabled>
                                        No hay POFs disponibles para este curso
                                    </SelectItem>
                                )}
                            </SelectContent>
                        </Select>

                        {/* Info adicional del POF seleccionado */}
                        {selectedPof && (
                            <div className="mt-2 rounded-md bg-muted p-3 text-sm">
                                <p>
                                    <strong>Docente:</strong>{' '}
                                    {selectedPof.docente}
                                </p>
                                <p>
                                    <strong>Materia:</strong>{' '}
                                    {selectedPof.materia}
                                </p>
                                <p>
                                    <strong>Condición:</strong>{' '}
                                    {selectedPof.condicion_docente}
                                </p>
                                <p>
                                    <strong>Obligaciones:</strong>{' '}
                                    {selectedPof.obligaciones} horas
                                </p>
                            </div>
                        )}
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
