<?php
// Clase base para las vistas del sistema. Facilita la reutilización del diseño HTML común (cabecera, navbar, scripts, etc.)
class PBase
{
    // Propiedad para almacenar el título de la página
    protected string $titulo;

    // Constructor que permite establecer un título personalizado, con valor por defecto "Sistema Iglesia"
    public function __construct(string $titulo = "Sistema Iglesia")
    {
        $this->titulo = $titulo;
    }

    // Método que imprime el encabezado HTML, incluyendo Bootstrap y el título
    protected function renderHead()
    {
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$this->titulo}</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body>";
    }

    // Método que incluye el archivo de la barra de navegación si existe
    protected function renderNavbar()
    {
        // Se verifica si el archivo navbar.php existe en la ruta relativa
        $navbarPath = __DIR__ . '/../includes/navbar.php';
        if (file_exists($navbarPath)) {
            require_once($navbarPath);
        }
    }

    // Método que inicia el contenedor principal del contenido de la página
    protected function renderInicioContenido()
    {
        echo "<div class='container mt-4'>";
    }

    // Método que finaliza el contenedor principal del contenido
    protected function renderFinContenido()
    {
        echo "</div>";
    }

    // Método que incluye los scripts necesarios al final del documento, como Bootstrap
    protected function renderScripts()
    {
        echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
        </body>
        </html>";
    }

    // Método público que renderiza toda la estructura inicial de la página (head, navbar, inicio del contenido)
    public function renderInicioCompleto()
    {
        $this->renderHead();            // Renderiza <head> y apertura de <body>
        $this->renderNavbar();         // Inserta la barra de navegación si existe
        $this->renderInicioContenido(); // Abre el contenedor principal de contenido
    }

    // Método público que renderiza la parte final de la página (cierre del contenido, scripts y cierre de HTML)
    public function renderFinCompleto()
    {
        $this->renderFinContenido(); // Cierra el contenedor principal de contenido
        $this->renderScripts();      // Inserta los scripts necesarios y cierra el documento HTML
    }
}
