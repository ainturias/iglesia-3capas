<?php
require_once(__DIR__ . '/../negocio/NMiembro.php');
require_once(__DIR__ . '/../negocio/NCurso.php');
require_once(__DIR__ . '/../negocio/NMinisterio.php');

// Esto es para incluir los archivos de encabezado y barra de navegación
require_once(__DIR__ . '/../includes/head.php');
require_once(__DIR__ . '/../includes/navbar.php');

class PMiembro
{
    private $nmiembro;
    private $ncursos;
    private $nministerios;
    private $miembros;
    private $mensaje;
    private $miembroEditando = null;

    public function __construct()
    {
        $this->nmiembro = new NMiembro();
        $this->ncursos = new NCurso();
        $this->nministerios = new NMinisterio();
        $this->mensaje = "";

        $this->procesarAcciones();
        $this->mostrarVista();
    }

    private function procesarAcciones()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->mensaje = $this->nmiembro->registrarMiembro($_POST);
            header("Location: PMiembro.php?msg=" . urlencode($this->mensaje));
            exit;
        }

        if (isset($_GET['eliminar'])) {
            $this->nmiembro->eliminarMiembro($_GET['eliminar']);
            header("Location: PMiembro.php");
            exit;
        }

        if (isset($_GET['editar'])) {
            $this->miembroEditando = $this->nmiembro->obtenerPorId($_GET['editar']);
        }

        $this->miembros = $this->nmiembro->listarMiembros();
    }

    private function mostrarVista()
    {
        $cursos = $this->ncursos->listarCursos();
        $ministerios = $this->nministerios->listarMinisterios();

        $value = function ($campo) {
            return $this->miembroEditando[$campo] ?? '';
        };

?>
        <div class="container">
            <h2 class="mb-4">Gestión de Miembros</h2>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
            <?php endif; ?>

            <form method="POST" class="row g-3">
                <!-- Campos del formulario -->
                <div class="col-md-6"><label class="form-label">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Apellido</label><input type="text" name="apellido" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">CI</label><input type="text" name="ci" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Fecha Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Dirección</label><input type="text" name="direccion" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Teléfono</label><input type="text" name="telefono" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Correo</label><input type="email" name="correo" class="form-control"></div>
                <div class="col-md-4">
                    <label class="form-label">Curso</label>
                    <select name="id_curso" class="form-select">
                        <option value="">-- Selecciona --</option>
                        <?php foreach ($cursos as $c): ?>
                            <option value="<?= $c['id_curso'] ?>"><?= $c['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ministerio</label>
                    <select name="id_ministerio" class="form-select">
                        <option value="">-- Selecciona --</option>
                        <?php foreach ($ministerios as $m): ?>
                            <option value="<?= $m['id_ministerio'] ?>"><?= $m['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar Miembro</button>
                </div>
            </form>

            <hr>
            <h4 class="mt-4">Miembros Registrados</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>CI</th>
                        <th>Correo</th>
                        <th>Curso</th>
                        <th>Ministerio</th>
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
                            <td><?= $m['curso_nombre'] ?? '—' ?></td>
                            <td><?= $m['ministerio_nombre'] ?? '—' ?></td>
                            <td>
                                <a href="?editar=<?= $m['id_miembro'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="?eliminar=<?= $m['id_miembro'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                            </td>
                            <!-- <td><a href="?eliminar=<?= $m['id_miembro'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</a></td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>
<?php
    }
}

// Ejecutar la clase
new PMiembro();
