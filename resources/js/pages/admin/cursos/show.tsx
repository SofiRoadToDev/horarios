import { useState } from 'react';
import AdminLayout from '@/layouts/AdminLayout';
import { ThemeProvider } from '@/contexts/ThemeContext';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Clock, GraduationCap, User } from 'lucide-react';
import { Button } from '@/components/ui/button';
import HorarioModal, { HorarioFormData } from '@/components/HorarioModal';
import { router } from '@inertiajs/react';

interface Curso {
    id: number;
    codigo: string;
    ciclo: string;
    turno: string;
    preceptor: string;
}

interface Dia {
    id: number;
    nombre: string;
}

interface BloqueHora {
    id: number;
    bloque: string;
}

interface HorarioCell {
    materia: string;
    docentes: string[];
}

interface Pof {
    id: number;
    docente: string;
    materia: string;
    condicion_docente: string;
    obligaciones: number;
}

interface CursoShowProps {
    curso: Curso;
    dias: Dia[];
    bloqueHorasMañana: BloqueHora[];
    bloqueHorasTarde: BloqueHora[];
    horarioGridMañana: Record<number, Record<number, HorarioCell>>;
    horarioGridTarde: Record<number, Record<number, HorarioCell>>;
    pofs: Pof[];
}

/**
 * Página de visualización del horario de un curso
 * Muestra tabla con formato: bloques horarios × días de la semana
 */
export default function CursoShow({
    curso,
    dias,
    bloqueHorasMañana,
    bloqueHorasTarde,
    horarioGridMañana,
    horarioGridTarde,
    pofs,
}: CursoShowProps) {
    const [modalOpen, setModalOpen] = useState(false);
    const [selectedCell, setSelectedCell] = useState<{
        diaId: number;
        bloqueHoraId: number;
        diaNombre: string;
        bloqueHoraNombre: string;
    } | null>(null);

    const handleCellClick = (
        diaId: number,
        bloqueHoraId: number,
        diaNombre: string,
        bloqueHoraNombre: string,
        hasHorario: boolean,
    ) => {
        // Solo abrir modal si la celda está vacía
        if (!hasHorario) {
            setSelectedCell({ diaId, bloqueHoraId, diaNombre, bloqueHoraNombre });
            setModalOpen(true);
        }
    };

    const handleSaveHorario = async (data: HorarioFormData) => {
        console.log('Enviando datos:', data);

        try {
            const response = await fetch('/admin/horarios', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                const errorData = await response.json();
                console.error('Error del servidor:', errorData);
                alert(`Error: ${errorData.message || 'Error al guardar horario'}`);
                throw new Error(errorData.message || 'Error al guardar horario');
            }

            const result = await response.json();
            console.log('Horario guardado:', result);

            // Recargar la página para ver los cambios
            router.reload();
        } catch (error) {
            console.error('Error guardando horario:', error);
            throw error;
        }
    };
    return (
        <ThemeProvider>
            <AdminLayout>
                <div className="space-y-6">
                    {/* Header con botón volver */}
                    <div className="flex items-center gap-4">
                        <Button
                            variant="ghost"
                            size="icon"
                            onClick={() => (window.location.href = '/admin/cursos')}
                        >
                            <ArrowLeft className="h-5 w-5" />
                        </Button>
                        <div>
                            <h1 className="text-3xl font-bold tracking-tight">
                                {curso.codigo}
                            </h1>
                            <p className="text-muted-foreground">
                                Horario del curso
                            </p>
                        </div>
                    </div>

                    {/* Info del curso */}
                    <div className="grid gap-4 md:grid-cols-3">
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">
                                    Ciclo
                                </CardTitle>
                                <GraduationCap className="h-4 w-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">
                                    {curso.ciclo}
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">
                                    Turno
                                </CardTitle>
                                <Clock className="h-4 w-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">
                                    {curso.turno}
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">
                                    Preceptor
                                </CardTitle>
                                <User className="h-4 w-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-lg font-bold">
                                    {curso.preceptor}
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Tabla de horarios - Turno Mañana */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Turno Mañana</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="overflow-x-auto">
                                <table className="w-full border-collapse">
                                    <thead>
                                        <tr>
                                            <th className="border border-border bg-muted p-2 text-left font-medium">
                                                Horario (Bloque)
                                            </th>
                                            {dias.map((dia) => (
                                                <th
                                                    key={dia.id}
                                                    className="border border-border bg-muted p-2 text-center font-medium"
                                                >
                                                    {dia.nombre}
                                                </th>
                                            ))}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {bloqueHorasMañana.map((bloque) => (
                                            <tr key={bloque.id}>
                                                <td className="border border-border bg-muted/50 p-2 text-sm font-medium">
                                                    {bloque.bloque}
                                                </td>
                                                {dias.map((dia) => {
                                                    const horario =
                                                        horarioGridMañana[
                                                            bloque.id
                                                        ]?.[dia.id];

                                                    return (
                                                        <td
                                                            key={dia.id}
                                                            className={`border border-border p-2 text-sm ${
                                                                !horario
                                                                    ? 'cursor-pointer hover:bg-accent/50 transition-colors'
                                                                    : ''
                                                            }`}
                                                            onClick={() =>
                                                                handleCellClick(
                                                                    dia.id,
                                                                    bloque.id,
                                                                    dia.nombre,
                                                                    bloque.bloque,
                                                                    !!horario,
                                                                )
                                                            }
                                                        >
                                                            {horario ? (
                                                                <div>
                                                                    <div className="font-medium">
                                                                        {
                                                                            horario.materia
                                                                        }
                                                                    </div>
                                                                    <div className="text-xs text-muted-foreground">
                                                                        {horario.docentes.join(
                                                                            ' / ',
                                                                        )}
                                                                    </div>
                                                                </div>
                                                            ) : (
                                                                <div className="text-center text-muted-foreground/30">
                                                                    +
                                                                </div>
                                                            )}
                                                        </td>
                                                    );
                                                })}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </CardContent>
                    </Card>

                    {/* Tabla de horarios - Turno Tarde */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Turno Tarde</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="overflow-x-auto">
                                <table className="w-full border-collapse">
                                    <thead>
                                        <tr>
                                            <th className="border border-border bg-muted p-2 text-left font-medium">
                                                Horario (Bloque)
                                            </th>
                                            {dias.map((dia) => (
                                                <th
                                                    key={dia.id}
                                                    className="border border-border bg-muted p-2 text-center font-medium"
                                                >
                                                    {dia.nombre}
                                                </th>
                                            ))}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {bloqueHorasTarde.map((bloque) => (
                                            <tr key={bloque.id}>
                                                <td className="border border-border bg-muted/50 p-2 text-sm font-medium">
                                                    {bloque.bloque}
                                                </td>
                                                {dias.map((dia) => {
                                                    const horario =
                                                        horarioGridTarde[
                                                            bloque.id
                                                        ]?.[dia.id];

                                                    return (
                                                        <td
                                                            key={dia.id}
                                                            className={`border border-border p-2 text-sm ${
                                                                !horario
                                                                    ? 'cursor-pointer hover:bg-accent/50 transition-colors'
                                                                    : ''
                                                            }`}
                                                            onClick={() =>
                                                                handleCellClick(
                                                                    dia.id,
                                                                    bloque.id,
                                                                    dia.nombre,
                                                                    bloque.bloque,
                                                                    !!horario,
                                                                )
                                                            }
                                                        >
                                                            {horario ? (
                                                                <div>
                                                                    <div className="font-medium">
                                                                        {
                                                                            horario.materia
                                                                        }
                                                                    </div>
                                                                    <div className="text-xs text-muted-foreground">
                                                                        {horario.docentes.join(
                                                                            ' / ',
                                                                        )}
                                                                    </div>
                                                                </div>
                                                            ) : (
                                                                <div className="text-center text-muted-foreground/30">
                                                                    +
                                                                </div>
                                                            )}
                                                        </td>
                                                    );
                                                })}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Modal de creación de horario */}
                {selectedCell && (
                    <HorarioModal
                        open={modalOpen}
                        onClose={() => setModalOpen(false)}
                        onSave={handleSaveHorario}
                        pofs={pofs}
                        diaId={selectedCell.diaId}
                        bloqueHoraId={selectedCell.bloqueHoraId}
                        diaNombre={selectedCell.diaNombre}
                        bloqueHoraNombre={selectedCell.bloqueHoraNombre}
                    />
                )}
            </AdminLayout>
        </ThemeProvider>
    );
}
