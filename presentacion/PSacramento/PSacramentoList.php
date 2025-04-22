<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NSacramento.php');

class PSacramentoList extends PBase
{
    private NSacramento $negocioSacramento;
    private array $sacramentos;

    public function __construct()
    {
        parent::__construct("Listado de Sacramentos");
        $this->negocioSacramento = new NSacramento();
        $this->procesarAcciones();
        $this->sacramentos = $this->negocioSacramento->listar();
    }

    private function procesarAcciones(): void
    {
        if (isset($_GET['eliminar'])) {
            $id = (int) $_GET['eliminar'];
            $this->negocioSacramento->eliminar($id);
            header("Location: PSacramentoList.php?msg=" . urlencode("Sacramento eliminado correctamente."));
            exit;
        }
    }

    public function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Listado de Sacramentos</h2>

        <div class="mb-3">
            <a href="PSacramentoCreate.php" class="btn btn-success">Registrar Nuevo Sacramento</a>
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->sacramentos as $s): ?>
                    <tr>
                        <td><?= $s['id_sacramento'] ?></td>
                        <td><?= htmlspecialchars($s['nombre']) ?></td>
                        <td><?= htmlspecialchars($s['descripcion']) ?></td>
                        <td>
                            <a href="PSacramentoEdit.php?id=<?= $s['id_sacramento'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="PSacramentoList.php?eliminar=<?= $s['id_sacramento'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar sacramento?')">Eliminar</a>
                            <a href="PSacramentoAsignar.php?id=<?= $s['id_sacramento'] ?>" class="btn btn-info btn-sm">Asignar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        $this->renderFinCompleto();
    }
}

$vista = new PSacramentoList();
$vista->mostrarVista();
