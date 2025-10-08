import AdminLayout from '@/layouts/AdminLayout';
import { ThemeProvider } from '@/contexts/ThemeContext';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { GraduationCap, User } from 'lucide-react';

interface Curso {
    id: number;
    codigo: string;
    ciclo: string;
    turno: string;
    preceptor: string;
}

interface CursosIndexProps {
    cursos: Curso[];
}

/**
 * Página de listado de cursos
 * Muestra cards para cada curso, al hacer click redirige al horario
 */
export default function CursosIndex({ cursos }: CursosIndexProps) {
    return (
        <ThemeProvider>
            <AdminLayout>
                <div className="space-y-6">
                    {/* Header */}
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">
                            Cursos
                        </h1>
                        <p className="text-muted-foreground">
                            Selecciona un curso para ver su horario
                        </p>
                    </div>

                    {/* Grid de Cards */}
                    <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        {cursos.map((curso) => (
                            <a
                                key={curso.id}
                                href={`/admin/cursos/${curso.id}`}
                                className="transition-transform hover:scale-105"
                            >
                                <Card className="h-full cursor-pointer hover:border-primary">
                                    <CardHeader>
                                        <div className="flex items-center justify-between">
                                            <CardTitle className="text-xl">
                                                {curso.codigo}
                                            </CardTitle>
                                            <GraduationCap className="h-6 w-6 text-muted-foreground" />
                                        </div>
                                    </CardHeader>
                                    <CardContent className="space-y-2">
                                        <div className="flex items-center gap-2 text-sm">
                                            <span className="font-medium text-muted-foreground">
                                                Ciclo:
                                            </span>
                                            <span>{curso.ciclo}</span>
                                        </div>
                                        <div className="flex items-center gap-2 text-sm">
                                            <span className="font-medium text-muted-foreground">
                                                Turno:
                                            </span>
                                            <span>{curso.turno}</span>
                                        </div>
                                        <div className="flex items-center gap-2 text-sm">
                                            <User className="h-4 w-4 text-muted-foreground" />
                                            <span className="text-muted-foreground">
                                                {curso.preceptor}
                                            </span>
                                        </div>
                                    </CardContent>
                                </Card>
                            </a>
                        ))}
                    </div>

                    {cursos.length === 0 && (
                        <div className="flex h-64 items-center justify-center">
                            <p className="text-muted-foreground">
                                No hay cursos registrados
                            </p>
                        </div>
                    )}
                </div>
            </AdminLayout>
        </ThemeProvider>
    );
}
