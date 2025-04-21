<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMiembroVer extends PBase
{
    private NMiembro $nmiembro;
    private array $miembro;
    private array $cursos;
    private array $ministerios;

    public function __construct()
    {
        parent::__construct("Detalle del Miembro");
        $this->nmiembro = new NMiembro();
        $this->procesar();
        $this->mostrarVista();
    }

    private function procesar(): void
    {
        if (!isset($_GET['id'])) {
            die("ID de miembro no proporcionado.");
        }

        $id = (int)$_GET['id'];
        $this->miembro = $this->nmiembro->obtenerPorId($id);
        $this->cursos = $this->nmiembro->obtenerCursosPorMiembro($id);
        $this->ministerios = $this->nmiembro->obtenerMinisteriosPorMiembro($id);
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Detalle del Miembro</h4>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> <?= htmlspecialchars($this->miembro['nombre']) ?></p>
                <p><strong>Apellido:</strong> <?= htmlspecialchars($this->miembro['apellido']) ?></p>
                <p><strong>CI:</strong> <?= htmlspecialchars($this->miembro['ci']) ?></p>
                <p><strong>Fecha Nacimiento:</strong> <?= htmlspecialchars($this->miembro['fecha_nacimiento']) ?></p>
                <p><strong>Dirección:</strong> <?= htmlspecialchars($this->miembro['direccion']) ?></p>
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($this->miembro['telefono']) ?></p>
                <p><strong>Correo:</strong> <?= htmlspecialchars($this->miembro['correo']) ?></p>
                <p><strong>Fecha de Registro:</strong> <?= htmlspecialchars($this->miembro['fecha_registro']) ?></p>
                <p><strong>Estado:</strong> <?= ucfirst(htmlspecialchars($this->miembro['estado'])) ?></p>
            </div>
        </div>

        <div class="row">
            <!-- Cursos -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Cursos Asignados</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($this->cursos)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($this->cursos as $curso): ?>
                                    <li class="list-group-item">
                                        <?= htmlspecialchars($curso['nombre']) ?><br>
                                        <small><strong>Nota:</strong> <?= $curso['nota'] ?? '—' ?> | <strong>Inscripción:</strong> <?= $curso['fecha_inscripcion'] ?? '—' ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">No tiene cursos registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Ministerios -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Ministerios Asignados</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($this->ministerios)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($this->ministerios as $min): ?>
                                    <li class="list-group-item">
                                        <?= htmlspecialchars($min['nombre']) ?><br>
                                        <small><strong>Desde:</strong> <?= $min['fecha_ingreso'] ?? '—' ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">No tiene ministerios registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <a href="PMiembroList.php" class="btn btn-secondary mt-3">← Volver al listado</a>

        <?php
        $this->renderFinCompleto();
    }
}

new PMiembroVer();
