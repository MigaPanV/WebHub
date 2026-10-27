<?php
// El formulario conserva el procesamiento que ya tenía el proyecto.
// Las notificaciones de sesión fueron retiradas.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiantes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<main class="container mt-5 mb-5">

    <div id="mensajeNotificacion"
        class="alert d-none"
        role="alert"
        aria-live="polite">
    </div>
    <header>
        <h1 class="h1">Registro de estudiantes</h1>
    </header>

    <div id="mensajeError" class="alert alert-danger d-none" role="alert"></div>

    <form action="Procesar.php" method="post" id="formEstudiante" novalidate>
        <fieldset>
            <legend>Información personal</legend>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" maxlength="100" class="form-control">
                <small id="contadorNombre" class="form-text">0 / 100 caracteres</small>
                <div class="invalid-feedback">Debe ingresar el nombre.</div>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" maxlength="100" class="form-control">
                <div class="invalid-feedback">Debe ingresar el apellido.</div>
            </div>

            <div class="mb-3">
                <label for="edad" class="form-label">Edad:</label>
                <input type="number" id="edad" name="edad" min="1" max="100" class="form-control">
                <div class="invalid-feedback">La edad debe estar entre 1 y 100 años.</div>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control">
                <div class="invalid-feedback">Ingrese un correo válido.</div>
            </div>

            <div class="mb-3">
                <label for="documento" class="form-label">Documento:</label>
                <input type="number" id="documento" name="documento" class="form-control">
            </div>

            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha nacimiento:</label>
                <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control">
            </div>

            <div class="mb-3">
                <label for="programa" class="form-label">Programa</label>
                <select id="programa" name="programa" class="form-select">
                    <option value="">Seleccione</option>
                    <option value="Ingeniería Informática">Ingeniería Informática</option>
                    <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                    <option value="Administración de Empresas">Administración de Empresas</option>
                </select>
            </div>
        </fieldset>

        <button type="submit" class="btn btn-primary">Enviar</button>
        <br><br>
        <a href="listar.php" class="btn btn-secondary">Ver estudiantes</a>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="js/app.js"></script>
</body>
</html>
