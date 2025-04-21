<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMiembroList extends PBase
{
    private NMiembro $negocioMiembro;
    private array $miembros;

    public function __construct()
    {
        parent::__construct("Listado de Miembros");
        $this->negocioMiembro = new NMiembro();
        $this->miembros = $this->negocioMiembro->listarMiembros();
    }

    public function mostrarVista()
    {
        $this->renderInicioCompleto();
?>

        <h2>Listado de Miembros</h2>

        <div class="mb-3">
            <a href="PMiembroCreate.php" class="btn btn-success">Registrar Nuevo Miembro</a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>CI</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->miembros as $miembro): ?>
                    <tr>
                        <td><?= $miembro['id_miembro'] ?></td>
                        <td><?= htmlspecialchars($miembro['nombre']) ?></td>
                        <td><?= htmlspecialchars($miembro['apellido']) ?></td>
                        <td><?= $miembro['ci'] ?></td>
                        <td><?= $miembro['correo'] ?></td>
                        <td><?= ucfirst($miembro['estado']) ?></td>
                        <td>
                            <a href="PMiembroVer.php?id=<?= $miembro['id_miembro'] ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="PMiembroEdit.php?id=<?= $miembro['id_miembro'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="PMiembroList.php?eliminar=<?= $miembro['id_miembro'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este miembro?')">Eliminar</a>
                        </td>
                        <!-- <td>
                            <a href="PMiembroEdit.php?id=<?= $miembro['id_miembro'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="PMiembroList.php?eliminar=<?= $miembro['id_miembro'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este miembro?')">Eliminar</a>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

<?php
        $this->renderFinCompleto();
    }

    public function procesarAcciones(): void
    {
        if (isset($_GET['eliminar'])) {
            $id = $_GET['eliminar'];
            $this->negocioMiembro->eliminarMiembro($id);
            header("Location: PMiembroList.php?msg=" . urlencode("Miembro eliminado correctamente."));
            exit;
        }
    }
}

$vista = new PMiembroList();
$vista->procesarAcciones();
$vista->mostrarVista();
