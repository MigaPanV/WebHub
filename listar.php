<?php
include("conexion.php");

$nombre = trim($_GET["nombre"] ?? "");
$apellido = trim($_GET["apellido"] ?? "");
$correo = trim($_GET["correo"] ?? "");
$programa = trim($_GET["programa"] ?? "");
$documento = trim($_GET["documento"] ?? "");
$orden = strtoupper($_GET["orden"] ?? "ASC");

if (!in_array($orden, ["ASC", "DESC"], true)) {
    $orden = "ASC";
}

$filtrosActivos = (
    $nombre !== "" ||
    $apellido !== "" ||
    $correo !== "" ||
    $programa !== "" ||
    $documento !== ""
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container mt-5 mb-5">
    <h2 class="mb-4">Listado de estudiantes</h2>

    <button class="btn btn-primary mb-3"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#panelFiltros"
            aria-expanded="<?= $filtrosActivos ? 'true' : 'false' ?>"
            aria-controls="panelFiltros">
        <?= $filtrosActivos ? 'Ocultar filtros' : 'Mostrar filtros' ?>
    </button>

    <div class="collapse <?= $filtrosActivos ? 'show' : '' ?> mb-4" id="panelFiltros">
        <div class="card">
            <div class="card-header">Buscar estudiantes</div>
            <div class="card-body">
                <form action="listar.php" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="orden" class="form-label">Ordenar estudiantes:</label>
                            <select name="orden" id="orden" class="form-select">
                                <option value="ASC" <?= $orden === "ASC" ? "selected" : "" ?>>A - Z</option>
                                <option value="DESC" <?= $orden === "DESC" ? "selected" : "" ?>>Z - A</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filtroNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="filtroNombre" name="nombre"
                                   placeholder="Buscar por nombre"
                                   value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="filtroApellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="filtroApellido" name="apellido"
                                   placeholder="Buscar por apellido"
                                   value="<?= htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="filtroCorreo" class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" id="filtroCorreo" name="correo"
                                   placeholder="Buscar por correo"
                                   value="<?= htmlspecialchars($correo, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="filtroPrograma" class="form-label">Programa académico</label>
                            <input type="text" class="form-control" id="filtroPrograma" name="programa"
                                   placeholder="Buscar por programa"
                                   value="<?= htmlspecialchars($programa, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="filtroDocumento" class="form-label">Documento (ID)</label>
                            <input type="text" class="form-control" id="filtroDocumento" name="documento"
                                   placeholder="Buscar por documento"
                                   value="<?= htmlspecialchars($documento, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                            <a href="listar.php" class="btn btn-secondary">Limpiar filtros</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <p>Resultados encontrados: <strong id="cantidadEstudiantes">Cargando...</strong></p>
    <div id="mensajeNotificacion"
        class="alert d-none"
        role="alert"
        aria-live="polite">
    </div>
    <div id="mensajeListado" class="alert alert-danger d-none" role="alert"></div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Edad</th>
                    <th>Correo</th>
                    <th>Documento</th>
                    <th>Programa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-estudiantes">
                <tr><td colspan="7" class="text-center">Cargando estudiantes...</td></tr>
            </tbody>
        </table>
    </div><br>

    <a href="index.php" class="btn btn-secondary">Agregar nuevo estudiante</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="js/app.js"></script>
</body>
</html>
