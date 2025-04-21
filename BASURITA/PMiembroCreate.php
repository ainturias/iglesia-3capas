<?php
require_once(__DIR__ . '/../../negocio/NMiembro.php');
require_once(__DIR__ . '/../../negocio/NCurso.php');
require_once(__DIR__ . '/../../negocio/NMinisterio.php');

// Esto es para incluir los archivos de encabezado y barra de navegación
require_once(__DIR__ . '/../../includes/head.php');
require_once(__DIR__ . '/../../includes/navbar.php');

$nmiembro = new NMiembro();
$ncursos = new NCurso();
$nministerios = new NMinisterio();

$cursos = $ncursos->listarCursos();
$ministerios = $nministerios->listarMinisterios();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = $nmiembro->registrarMiembro($_POST);
    header("Location: PMiembroList.php?msg=" . urlencode($mensaje));
    exit;
}
?>

<div class="container mt-4">
    <h2>Registrar Miembro</h2>
    <?php if (!empty($mensaje)) : ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
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
            <button type="submit" class="btn btn-primary">Guardar Miembro</button>
            <a href="PMiembroList.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>