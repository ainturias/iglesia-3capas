<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMinisterio.php');

class PMinisterioList extends PBase
{
    private NMinisterio $negocioMinisterio;
    private array $ministerios;

    public function __construct()
    {
        parent::__construct("Listado de Ministerios");
        $this->negocioMinisterio = new NMinisterio();
        $this->procesarAcciones();
        $this->ministerios = $this->negocioMinisterio->listar();
    }

    private function procesarAcciones(): void
    {
        if (isset($_GET['eliminar'])) {
            $id = (int) $_GET['eliminar'];
            $this->negocioMinisterio->eliminar($id);
            header("Location: PMinisterioList.php?msg=" . urlencode("Ministerio eliminado correctamente."));
            exit;
        }
    }

    public function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Listado de Ministerios</h2>

        <div class="mb-3">
            <a href="PMinisterioCreate.php" class="btn btn-success">Registrar Nuevo Ministerio</a>
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
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->ministerios as $m): ?>
                    <tr>
                        <td><?= $m['id_ministerio'] ?></td>
                        <td><?= htmlspecialchars($m['nombre']) ?></td>
                        <td><?= htmlspecialchars($m['descripcion']) ?></td>
                        <td><?= $m['fecha_creacion'] ?></td>
                        <td>
                            <a href="PMinisterioEdit.php?id=<?= $m['id_ministerio'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="PMinisterioList.php?eliminar=<?= $m['id_ministerio'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar ministerio?')">Eliminar</a>
                            <a href="PMinisterioAsignar.php?id=<?= $m['id_ministerio'] ?>" class="btn btn-info btn-sm">Seleccionar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        $this->renderFinCompleto();
    }
}

$vista = new PMinisterioList();
$vista->mostrarVista();
