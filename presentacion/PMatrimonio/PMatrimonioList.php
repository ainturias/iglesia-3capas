<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMatrimonio.php');

class PMatrimonioList extends PBase
{
    private NMatrimonio $negocioMatrimonio;
    private array $matrimonios;

    public function __construct()
    {
        parent::__construct("Listado de Matrimonios");
        $this->negocioMatrimonio = new NMatrimonio();

        $this->procesarAcciones();
        $this->matrimonios = $this->negocioMatrimonio->listar();
    }

    private function procesarAcciones(): void
    {
        if (isset($_GET['eliminar'])) {
            $id = (int) $_GET['eliminar'];
            $this->negocioMatrimonio->eliminar($id);
            header("Location: PMatrimonioList.php?msg=" . urlencode("Matrimonio eliminado correctamente."));
            exit;
        }
    }

    public function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Listado de Matrimonios</h2>

        <div class="mb-3">
            <a href="PMatrimonioCreate.php" class="btn btn-success">Registrar Nuevo Matrimonio</a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Esposo</th>
                    <th>Esposa</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Testigos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->matrimonios as $m): ?>
                    <tr>
                        <td><?= $m['id_matrimonio'] ?></td>
                        <td><?= htmlspecialchars($m['nombre_esposo']) ?></td>
                        <td><?= htmlspecialchars($m['nombre_esposa']) ?></td>
                        <td><?= $m['fecha'] ?></td>
                        <td><?= $m['lugar'] ?></td>
                        <td><?= $m['testigos'] ?></td>
                        <td>
                            <a href="PMatrimonioEdit.php?id=<?= $m['id_matrimonio'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="PMatrimonioList.php?eliminar=<?= $m['id_matrimonio'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar matrimonio?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        $this->renderFinCompleto();
    }
}

$vista = new PMatrimonioList();
$vista->mostrarVista();
