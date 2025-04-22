<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NSacramento.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PSacramentoAsignar extends PBase
{
    private NSacramento $negocioSacramento;
    private NMiembro $negocioMiembro;
    private array $sacramento;
    private array $miembrosAsignados = [];
    private array $miembrosDisponibles = [];

    public function __construct()
    {
        parent::__construct("Asignar Sacramento");

        $this->negocioSacramento = new NSacramento();
        $this->negocioMiembro = new NMiembro();

        if (!isset($_GET['id'])) {
            header("Location: PSacramentoList.php?msg=" . urlencode("ID del sacramento no especificado."));
            exit;
        }

        $idSacramento = (int)$_GET['id'];
        $this->sacramento = $this->negocioSacramento->obtenerPorId($idSacramento);

        if (!$this->sacramento) {
            header("Location: PSacramentoList.php?msg=" . urlencode("Sacramento no encontrado."));
            exit;
        }

        // Procesar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMiembro = (int)$_POST['id_miembro'];
            $fecha = $_POST['fecha'] ?? '';
            $lugar = $_POST['lugar'] ?? '';

            if ($_POST['accion'] === 'asignar') {
                $this->negocioSacramento->asignarSacramentoAmiembro($idMiembro, $idSacramento, $fecha, $lugar);
            } elseif ($_POST['accion'] === 'quitar') {
                $this->negocioSacramento->quitarSacramento($idMiembro, $idSacramento);
            }

            header("Location: PSacramentoAsignar.php?id=$idSacramento");
            exit;
        }

        // Cargar datos
        $this->miembrosAsignados = $this->negocioSacramento->obtenerMiembrosConSacramento($idSacramento);
        $this->miembrosDisponibles = $this->negocioSacramento->obtenerMiembrosSinSacramento($idSacramento);

        $this->mostrarVista();
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Asignar Sacramento: <?= htmlspecialchars($this->sacramento['nombre']) ?></h2>

        <h4>Miembros que ya recibieron el Sacramento</h4>
        <?php if (count($this->miembrosAsignados)): ?>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->miembrosAsignados as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?></td>
                            <td><?= $m['fecha'] ?></td>
                            <td><?= htmlspecialchars($m['lugar']) ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_miembro" value="<?= $m['id_miembro'] ?>">
                                    <button name="accion" value="quitar" class="btn btn-danger btn-sm" onclick="return confirm('¿Quitar sacramento de este miembro?')">Quitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No hay miembros registrados aún.</p>
        <?php endif; ?>

        <hr>
        <h4>Asignar Nuevo Sacramento</h4>
        <form method="POST" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Miembro</label>
                <select name="id_miembro" class="form-select" required>
                    <option value="">-- Selecciona un miembro --</option>
                    <?php foreach ($this->miembrosDisponibles as $m): ?>
                        <option value="<?= $m['id_miembro'] ?>"><?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Lugar</label>
                <input type="text" name="lugar" class="form-control" required>
            </div>
            <div class="col-md-2 d-grid align-items-end">
                <button name="accion" value="asignar" class="btn btn-success">Asignar</button>
            </div>
        </form>

        <a href="PSacramentoList.php" class="btn btn-secondary mt-4">Volver</a>

        <?php
        $this->renderFinCompleto();
    }
}

new PSacramentoAsignar();
