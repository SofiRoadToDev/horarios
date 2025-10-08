import AdminLayout from '@/layouts/AdminLayout';
import { ThemeProvider } from '@/contexts/ThemeContext';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Clock, GraduationCap, User } from 'lucide-react';
import { Button } from '@/components/ui/button';

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

interface CursoShowProps {
    curso: Curso;
    dias: Dia[];
    bloqueHoras: BloqueHora[];
    horarioGrid: Record<number, Record<number, HorarioCell>>;
}

/**
 * Página de visualización del horario de un curso
 * Muestra tabla con formato: bloques horarios × días de la semana
 */
export default function CursoShow({
    curso,
    dias,
    bloqueHoras,
    horarioGrid,
}: CursoShowProps) {
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

                    {/* Tabla de horarios */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Horario Semanal</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="overflow-x-auto">
                                <table className="w-full border-collapse">
                                    <thead>
                                        <tr>
                                            <th className="border border-border bg-muted p-2 text-left font-medium">
                                                horario(bloque)
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
                                        {bloqueHoras.map((bloque) => (
                                            <tr key={bloque.id}>
                                                <td className="border border-border bg-muted/50 p-2 text-sm font-medium">
                                                    {bloque.bloque}
                                                </td>
                                                {dias.map((dia) => {
                                                    const horario =
                                                        horarioGrid[bloque.id]?.[
                                                            dia.id
                                                        ];

                                                    return (
                                                        <td
                                                            key={dia.id}
                                                            className="border border-border p-2 text-sm"
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
                                                                    -
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
            </AdminLayout>
        </ThemeProvider>
    );
}
