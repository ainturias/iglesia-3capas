<?php
require_once(__DIR__ . '/../../negocio/NMiembro.php');

require_once(__DIR__ . '/../../includes/head.php');
require_once(__DIR__ . '/../../includes/navbar.php');

class PMiembroList
{
    private $nmiembro;
    private $miembros;

    public function __construct()
    {
        $this->nmiembro = new NMiembro();
        $this->listarMiembros();
        $this->mostrarVista();
    }

    private function listarMiembros()
    {
        $this->miembros = $this->nmiembro->listarMiembros();
    }

    private function mostrarVista()
    {
?>
        <div class="container">
            <h2 class="mb-4">Lista de Miembros</h2>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <a href="PMiembroCreate.php" class="btn btn-success">Registrar Nuevo Miembro</a>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>CI</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->miembros as $m): ?>
                        <tr>
                            <td><?= $m['id_miembro'] ?></td>
                            <td><?= $m['nombre'] ?></td>
                            <td><?= $m['apellido'] ?></td>
                            <td><?= $m['ci'] ?></td>
                            <td><?= $m['correo'] ?></td>
                            <td>
                                <a href="PMiembroEdit.php?id=<?= $m['id_miembro'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="PMiembroDelete.php?id=<?= $m['id_miembro'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    }
}

new PMiembroList();


