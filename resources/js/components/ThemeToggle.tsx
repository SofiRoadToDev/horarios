import { Moon, Sun } from 'lucide-react';
import { Button } from './ui/button';
import { useTheme } from '@/contexts/ThemeContext';

/**
 * Componente para cambiar entre tema claro y oscuro
 */
export function ThemeToggle() {
    const { theme, toggleTheme } = useTheme();

    return (
        <Button
            variant="ghost"
            size="icon"
            onClick={toggleTheme}
            aria-label="Cambiar tema"
        >
            {theme === 'light' ? (
                <Moon className="h-5 w-5" />
            ) : (
                <Sun className="h-5 w-5" />
            )}
        </Button>
    );
}
