<?php
require_once(__DIR__ . '/../negocio/GestorMiembro.php');
require_once(__DIR__ . '/../negocio/GestorCurso.php');
require_once(__DIR__ . '/../negocio/GestorMinisterio.php');

$gestor = new GestorMiembro();
$gestorCurso = new GestorCurso();
$gestorMinisterio = new GestorMinisterio();
$mensaje = "";

// Registrar nuevo miembro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = $gestor->registrarMiembro($_POST);
    header("Location: miembrosForm.php?msg=" . urlencode($mensaje));
    exit;
}


// Eliminar miembro
if (isset($_GET['eliminar'])) {
    $gestor->eliminarMiembro($_GET['eliminar']);
    header("Location: miembrosForm.php"); // Evita reenvío por GET
    exit;
}

// Obtener todos los miembros
$miembros = $gestor->listarMiembros();

// Obtener cursos y ministerios
$cursos = $gestorCurso->listarCursos();
$ministerios = $gestorMinisterio->listarMinisterios();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Miembros</title>
</head>

<body>
    <h1>Gestión de Miembros</h1>

    <?php if (isset($_GET['msg'])): ?>
        <p><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre: <input type="text" name="nombre" required></label><br>
        <label>Apellido: <input type="text" name="apellido" required></label><br>
        <label>CI: <input type="text" name="ci" required></label><br>
        <label>Fecha Nacimiento: <input type="date" name="fecha_nacimiento" required></label><br>
        <label>Dirección: <input type="text" name="direccion"></label><br>
        <label>Teléfono: <input type="text" name="telefono"></label><br>
        <label>Correo: <input type="email" name="correo"></label><br>
        <label>Curso:
            <select name="id_curso">
                <option value="">-- Selecciona un curso --</option>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['id_curso'] ?>"><?= $curso['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>

        <label>Ministerio:
            <select name="id_ministerio">
                <option value="">-- Selecciona un ministerio --</option>
                <?php foreach ($ministerios as $min): ?>
                    <option value="<?= $min['id_ministerio'] ?>"><?= $min['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>

        <button type="submit">Registrar Miembro</button>
    </form>

    <h2>Miembros Registrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>CI</th>
            <th>Fecha Nacimiento</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Fecha Registro</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($miembros as $m): ?>
            <tr>
                <td><?= $m['id_miembro'] ?></td>
                <td><?= $m['nombre'] ?></td>
                <td><?= $m['apellido'] ?></td>
                <td><?= $m['ci'] ?></td>
                <td><?= $m['fecha_nacimiento'] ?></td>
                <td><?= $m['direccion'] ?></td>
                <td><?= $m['telefono'] ?></td>
                <td><?= $m['correo'] ?></td>
                <td><?= $m['fecha_registro'] ?></td>
                <td><?= $m['estado'] ?></td>
                <td>
                    <a href="?eliminar=<?= $m['id_miembro'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>


</body>

</html>