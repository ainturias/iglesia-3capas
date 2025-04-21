<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NCurso.php');

class PCursoList extends PBase
{
    private NCurso $negocioCurso;
    private array $cursos;

    public function __construct()
    {
        parent::__construct("Listado de Cursos");
        $this->negocioCurso = new NCurso();
        $this->procesarAcciones();
        $this->cursos = $this->negocioCurso->listarCursos();
    }

    private function procesarAcciones(): void
    {
        if (isset($_GET['eliminar'])) {
            $id = (int) $_GET['eliminar'];
            $this->negocioCurso->eliminar($id);
            header("Location: PCursoList.php?msg=" . urlencode("Curso eliminado correctamente."));
            exit;
        }
    }

    public function mostrarVista(): void
    {
        $this->renderInicioCompleto();
?>

        <h2>Listado de Cursos</h2>

        <div class="mb-3">
            <a href="PCursoCreate.php" class="btn btn-success">Registrar Nuevo Curso</a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nivel</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->cursos as $curso): ?>
                    <tr>
                        <td><?= $curso['id_curso'] ?></td>
                        <td><?= htmlspecialchars($curso['nombre']) ?></td>
                        <td><?= htmlspecialchars($curso['descripcion']) ?></td>
                        <td><?= htmlspecialchars($curso['nivel']) ?></td>
                        <td><?= $curso['fecha_inicio'] ?></td>
                        <td><?= $curso['fecha_fin'] ?></td>
                        <td>
                            <a href="PCursoEdit.php?id=<?= $curso['id_curso'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="PCursoList.php?eliminar=<?= $curso['id_curso'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar curso?')">Eliminar</a>
                            <a href="PCursoAsignar.php?id=<?= $curso['id_curso'] ?>" class="btn btn-info btn-sm">Asignar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


<?php
        $this->renderFinCompleto();
    }
}

$vista = new PCursoList();
$vista->mostrarVista();
