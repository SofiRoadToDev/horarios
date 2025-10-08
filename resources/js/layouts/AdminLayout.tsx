import { Link } from '@inertiajs/react';
import { BookOpen, GraduationCap, Users } from 'lucide-react';
import { ThemeToggle } from '@/components/ThemeToggle';
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarProvider,
    SidebarTrigger,
} from '@/components/ui/sidebar';

interface AdminLayoutProps {
    children: React.ReactNode;
}

/**
 * Layout principal del dashboard de administración
 * Incluye sidebar con navegación y header con theme toggle
 */
export default function AdminLayout({ children }: AdminLayoutProps) {
    return (
        <SidebarProvider>
            <div className="flex min-h-screen w-full">
                {/* Sidebar */}
                <Sidebar>
                    <SidebarHeader className="border-b border-sidebar-border px-4 py-3">
                        <h2 className="text-lg font-semibold text-sidebar-foreground">
                            Sistema de Horarios
                        </h2>
                    </SidebarHeader>
                    <SidebarContent>
                        <SidebarGroup>
                            <SidebarGroupLabel>Gestión</SidebarGroupLabel>
                            <SidebarGroupContent>
                                <SidebarMenu>
                                    <SidebarMenuItem>
                                        <SidebarMenuButton asChild>
                                            <a href="/admin/cursos">
                                                <GraduationCap className="h-4 w-4" />
                                                <span>Cursos</span>
                                            </a>
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                    <SidebarMenuItem>
                                        <SidebarMenuButton asChild>
                                            <a href="/admin/docentes">
                                                <Users className="h-4 w-4" />
                                                <span>Docentes</span>
                                            </a>
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                    <SidebarMenuItem>
                                        <SidebarMenuButton asChild>
                                            <a href="/admin/materias">
                                                <BookOpen className="h-4 w-4" />
                                                <span>Materias</span>
                                            </a>
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                </SidebarMenu>
                            </SidebarGroupContent>
                        </SidebarGroup>
                    </SidebarContent>
                </Sidebar>

                {/* Main Content */}
                <div className="flex flex-1 flex-col">
                    {/* Header */}
                    <header className="sticky top-0 z-10 flex h-14 items-center justify-between border-b bg-background px-4">
                        <SidebarTrigger />
                        <ThemeToggle />
                    </header>

                    {/* Page Content */}
                    <main className="flex-1 p-6">{children}</main>
                </div>
            </div>
        </SidebarProvider>
    );
}
