<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMinisterio.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMinisterioAsignar extends PBase
{
    private NMinisterio $negocioMinisterio;
    private NMiembro $negocioMiembro;
    private array $ministerio;
    private array $miembrosAsignados = [];
    private array $miembrosDisponibles = [];

    public function __construct()
    {
        parent::__construct("Asignar Miembros al Ministerio");

        $this->negocioMinisterio = new NMinisterio();
        $this->negocioMiembro = new NMiembro();

        if (!isset($_GET['id'])) {
            header("Location: PMinisterioList.php?msg=" . urlencode("ID del ministerio no especificado."));
            exit;
        }

        $idMinisterio = (int)$_GET['id'];
        $this->ministerio = $this->negocioMinisterio->obtenerPorId($idMinisterio);

        if (!$this->ministerio) {
            header("Location: PMinisterioList.php?msg=" . urlencode("Ministerio no encontrado."));
            exit;
        }

        // Procesar acciones POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMiembro = (int)$_POST['id_miembro'];
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'asignar') {
                $fecha = date('Y-m-d');
                $this->negocioMinisterio->asignarMiembro($idMinisterio, $idMiembro, $fecha);
            } elseif ($accion === 'quitar') {
                $this->negocioMinisterio->quitarMiembro($idMinisterio, $idMiembro);
            }

            header("Location: PMinisterioAsignar.php?id=$idMinisterio");
            exit;
        }

        // Cargar datos
        $this->miembrosAsignados = $this->negocioMinisterio->obtenerMiembrosAsignados($idMinisterio);
        $this->miembrosDisponibles = $this->negocioMinisterio->obtenerMiembrosNoAsignados($idMinisterio);

        $this->mostrarVista();
    }

    private function mostrarVista()
    {
        $this->renderInicioCompleto();
?>
        <h2>Miembros del Ministerio: <?= htmlspecialchars($this->ministerio['nombre']) ?></h2>

        <h4>Miembros Asignados</h4>
        <?php if (count($this->miembrosAsignados)): ?>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de Ingreso</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->miembrosAsignados as $m): ?>
                        <tr>
                            <td><?= $m['nombre'] . ' ' . $m['apellido'] ?></td>
                            <td><?= $m['fecha_ingreso'] ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_miembro" value="<?= $m['id_miembro'] ?>">
                                    <button name="accion" value="quitar" class="btn btn-danger btn-sm" onclick="return confirm('¿Quitar del ministerio?')">Quitar</button>
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
                        <option value="<?= $m['id_miembro'] ?>"><?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button name="accion" value="asignar" class="btn btn-success">Asignar</button>
            </div>
        </form>

        <a href="PMinisterioList.php" class="btn btn-secondary mt-3">Volver</a>
<?php
        $this->renderFinCompleto();
    }
}

new PMinisterioAsignar();
