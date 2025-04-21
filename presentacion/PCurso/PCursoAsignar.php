<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NCurso.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PCursoAsignar extends PBase
{
    private NCurso $negocioCurso;
    private NMiembro $negocioMiembro;
    private array $curso;
    private array $miembrosDisponibles = [];
    private array $miembrosAsignados = [];

    public function __construct()
    {
        parent::__construct("Asignar Miembros al Curso");

        $this->negocioCurso = new NCurso();
        $this->negocioMiembro = new NMiembro();

        if (!isset($_GET['id'])) {
            header("Location: PCursoList.php?msg=" . urlencode("ID del curso no especificado."));
            exit;
        }

        $idCurso = (int)$_GET['id'];
        $this->curso = $this->negocioCurso->obtenerPorId($idCurso);
        if (!$this->curso) {
            header("Location: PCursoList.php?msg=" . urlencode("Curso no encontrado."));
            exit;
        }

        // Acciones POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id_miembro'], $_POST['accion'])) {
                $idMiembro = (int)$_POST['id_miembro'];
                $nota = $_POST['nota'] ?? null;

                if ($_POST['accion'] === 'inscribir') {
                    $this->negocioCurso->asignarMiembro($idCurso, $idMiembro, $nota, date('Y-m-d'));
                    //$this->negocioCurso->asignarMiembro($idCurso, $idMiembro);
                } elseif ($_POST['accion'] === 'quitar') {
                    $this->negocioCurso->quitarMiembro($idCurso, $idMiembro);
                } elseif ($_POST['accion'] === 'calificar' && is_numeric($nota)) {
                    $this->negocioCurso->calificarMiembro($idCurso, $idMiembro, floatval($nota));
                }

                header("Location: PCursoAsignar.php?id=$idCurso");
                exit;
            }
        }

        // Cargar datos
        $this->miembrosDisponibles = $this->negocioCurso->obtenerMiembrosNoAsignados($idCurso);
        $this->miembrosAsignados = $this->negocioCurso->obtenerMiembrosAsignados($idCurso);

        $this->mostrarVista();
    }

    private function mostrarVista()
    {
        $this->renderInicioCompleto();
?>
        <h2>Miembros del Curso: <?= htmlspecialchars($this->curso['nombre']) ?></h2>

        <h4>Miembros Asignados</h4>
        <?php if (count($this->miembrosAsignados)): ?>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Nota</th>
                        <th>Estado</th> <!-- NUEVO -->
                        <th>Fecha de Inscripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->miembrosAsignados as $m): ?>
                        <tr>
                            <td><?= $m['nombre'] . ' ' . $m['apellido'] ?></td>
                            <td><?= $m['nota'] ?? '-' ?></td>
                            <td><?= ucfirst($m['estado'] ?? 'pendiente') ?></td> <!-- NUEVO -->
                            <td><?= $m['fecha_inscripcion'] ?? '-' ?></td>
                            <td>
                                <form method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="id_miembro" value="<?= $m['id_miembro'] ?>">
                                    <input type="number" name="nota" class="form-control form-control-sm" placeholder="Nota" step="0.01" style="width: 100px;">
                                    <button name="accion" value="calificar" class="btn btn-primary btn-sm">Calificar</button>
                                    <button name="accion" value="quitar" class="btn btn-danger btn-sm" onclick="return confirm('¿Quitar del curso?')">Quitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No hay miembros asignados.</p>
        <?php endif; ?>

        <h4 class="mt-4">Asignar Nuevo Miembro</h4>
        <form method="POST" class="row g-2 align-items-center">
            <div class="col-md-6">

                <select name="id_miembro" class="form-select" required>
                    <option value="">-- Selecciona un miembro --</option>
                    <?php foreach ($this->miembrosDisponibles as $m): ?>
                        <option value="<?= $m['id_miembro'] ?>">
                            <?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="col-md-2">
                <button name="accion" value="inscribir" class="btn btn-success">Inscribir</button>
            </div>
        </form>

        <a href="PCursoList.php" class="btn btn-secondary mt-3">Volver</a>
<?php
        $this->renderFinCompleto();
    }
}

new PCursoAsignar();
