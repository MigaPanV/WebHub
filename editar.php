

<?php
 
include("conexion.php");
 
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
 
if (!$id) {
    die("Identificador no válido");
}
 
$consulta = $conexion->prepare(
    "SELECT * FROM estudiantes WHERE id = ?"
);
 
$consulta->bind_param("i", $id);
$consulta->execute();
$resultado = $consulta->get_result();
$estudiante = $resultado->fetch_assoc();
 
if (!$estudiante) {
    die("Estudiante no encontrado");
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Editar</title>
</head>
<body>
    <main>

        <div class="container mt-5">
            <h2>Editar estudiante</h2>
        
            <form action="actualizar.php" method="POST">
    
                <input type="hidden" name="id" value="<?php echo $estudiante['ID']; ?>">
    
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo $estudiante['nombre']; ?>" required>
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="<?php echo $estudiante['apellido']; ?>" required>
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" value="<?php echo $estudiante['correo']; ?>" required>
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Edad</label>
                    <input type="number" name="edad" class="form-control" value="<?php echo $estudiante['edad']; ?>" required>
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Programa</label>
                    <select name="programa" class="form-select" required>
                    <option value=""> <?php echo $estudiante["programa"] ?> </option>
                    <option value="Ingeniería Informática">Ingeniería Informática</option>
                    <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                    <option value="Administración de Empresas">Administración de Empresas</option>
                    </select>
                </div>
    
                <button type="submit" class="btn btn-success">Guardar cambios</button><br><br>
                <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    
            </form>
        </div>

    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>