<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMembresia.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMembresiaList extends PBase
{
    private NMembresia $negocioMembresia;
    private NMiembro $negocioMiembro;
    private array $membresias;
    private array $miembrosPorId = [];

    public function __construct()
    {
        parent::__construct("Listado de Membresías");
        $this->negocioMembresia = new NMembresia();
        $this->negocioMiembro = new NMiembro();

        $this->clickEliminar();
        $this->membresias = $this->negocioMembresia->listar();

        // Obtener todos los miembros una sola vez y asociarlos por ID
        foreach ($this->negocioMiembro->listar() as $miembro) {
            $this->miembrosPorId[$miembro['id_miembro']] = $miembro;
        }
    }

    private function clickEliminar(): void
    {
        if (isset($_GET['eliminar'])) {
            $id = (int) $_GET['eliminar'];
            $this->negocioMembresia->eliminar($id);
            header("Location: PMembresiaList.php?msg=" . urlencode("Membresía eliminada correctamente."));
            exit;
        }
    }

    public function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Listado de Membresías</h2>

        <div class="mb-3">
            <a href="PMembresiaCreate.php" class="btn btn-success">Registrar Nueva Membresía</a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Miembro</th>
                    <th>Tipo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->membresias as $m): ?>
                    <?php
                    $miembro = $this->miembrosPorId[$m['id_miembro']] ?? ['nombre' => 'Desconocido', 'apellido' => ''];
                    ?>
                    <tr>
                        <td><?= $m['id_membresia'] ?></td>
                        <td><?= htmlspecialchars($miembro['nombre'] . ' ' . $miembro['apellido']) ?></td>
                        <td><?= htmlspecialchars($m['tipo']) ?></td>
                        <td><?= $m['fecha_inicio'] ?></td>
                        <td><?= $m['fecha_fin'] ?? '-' ?></td>
                        <td><?= ucfirst($m['estado']) ?></td>
                        <td>
                            <a href="PMembresiaEdit.php?id=<?= $m['id_membresia'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="PMembresiaList.php?eliminar=<?= $m['id_membresia'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar membresía?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        $this->renderFinCompleto();
    }
}

$vista = new PMembresiaList();
$vista->mostrarVista();
