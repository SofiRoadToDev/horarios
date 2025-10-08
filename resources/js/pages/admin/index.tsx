import AdminLayout from '@/layouts/AdminLayout';
import { ThemeProvider } from '@/contexts/ThemeContext';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { BookOpen, GraduationCap, Users, TrendingUp } from 'lucide-react';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';

interface Stats {
    docentes: number;
    cursos: number;
    materias: number;
}

interface PofReciente {
    id: number;
    tipo: 'Alta' | 'Baja';
    docente: string;
    materia: string;
    curso: string;
    fecha: string;
    obligaciones: number;
}

interface AdminIndexProps {
    stats: Stats;
    pofsRecientes: PofReciente[];
}

/**
 * Página principal del dashboard administrativo
 * Muestra estadísticas y POF recientes
 */
export default function AdminIndex({ stats, pofsRecientes }: AdminIndexProps) {
    return (
        <ThemeProvider>
            <AdminLayout>
                <div className="space-y-6">
                    {/* Header */}
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">
                            Dashboard
                        </h1>
                        <p className="text-muted-foreground">
                            Resumen general del sistema de horarios
                        </p>
                    </div>

                    {/* Stats Cards */}
                    <div className="grid gap-4 md:grid-cols-3">
                        {/* Card Docentes */}
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">
                                    Total Docentes
                                </CardTitle>
                                <Users className="h-4 w-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">
                                    {stats.docentes}
                                </div>
                                <p className="text-xs text-muted-foreground">
                                    Docentes registrados
                                </p>
                            </CardContent>
                        </Card>

                        {/* Card Cursos */}
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">
                                    Total Cursos
                                </CardTitle>
                                <GraduationCap className="h-4 w-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">
                                    {stats.cursos}
                                </div>
                                <p className="text-xs text-muted-foreground">
                                    Cursos activos
                                </p>
                            </CardContent>
                        </Card>

                        {/* Card Materias */}
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">
                                    Total Materias
                                </CardTitle>
                                <BookOpen className="h-4 w-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">
                                    {stats.materias}
                                </div>
                                <p className="text-xs text-muted-foreground">
                                    Materias disponibles
                                </p>
                            </CardContent>
                        </Card>
                    </div>

                    {/* POF Recientes */}
                    <Card>
                        <CardHeader>
                            <div className="flex items-center justify-between">
                                <div>
                                    <CardTitle>
                                        Movimientos POF Recientes
                                    </CardTitle>
                                    <p className="text-sm text-muted-foreground">
                                        Últimas altas y bajas registradas
                                    </p>
                                </div>
                                <TrendingUp className="h-5 w-5 text-muted-foreground" />
                            </div>
                        </CardHeader>
                        <CardContent>
                            {pofsRecientes.length > 0 ? (
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Tipo</TableHead>
                                            <TableHead>Docente</TableHead>
                                            <TableHead>Materia</TableHead>
                                            <TableHead>Curso</TableHead>
                                            <TableHead>Fecha</TableHead>
                                            <TableHead className="text-right">
                                                Obligaciones
                                            </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {pofsRecientes.map((pof) => (
                                            <TableRow key={pof.id}>
                                                <TableCell>
                                                    <Badge
                                                        variant={
                                                            pof.tipo === 'Alta'
                                                                ? 'default'
                                                                : 'destructive'
                                                        }
                                                    >
                                                        {pof.tipo}
                                                    </Badge>
                                                </TableCell>
                                                <TableCell className="font-medium">
                                                    {pof.docente}
                                                </TableCell>
                                                <TableCell>
                                                    {pof.materia}
                                                </TableCell>
                                                <TableCell>
                                                    {pof.curso}
                                                </TableCell>
                                                <TableCell>
                                                    {new Date(
                                                        pof.fecha,
                                                    ).toLocaleDateString(
                                                        'es-AR',
                                                    )}
                                                </TableCell>
                                                <TableCell className="text-right">
                                                    {pof.obligaciones}
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            ) : (
                                <div className="flex h-32 items-center justify-center text-muted-foreground">
                                    No hay movimientos POF registrados
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </AdminLayout>
        </ThemeProvider>
    );
}
