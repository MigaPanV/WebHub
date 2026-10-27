<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id <= 0) {
    header("Location: listar.php?estado=id_invalido");
    exit();
}

$eliminar = $conexion->prepare(
    "DELETE FROM estudiantes WHERE ID = ?"
);

if (!$eliminar) {
    $conexion->close();
    header("Location: listar.php?estado=error_eliminar");
    exit();
}

$eliminar->bind_param("i", $id);

if (!$eliminar->execute()) {
    $eliminar->close();
    $conexion->close();

    header("Location: listar.php?estado=error_eliminar");
    exit();
}

if ($eliminar->affected_rows > 0) {
    $estado = "eliminado";
} else {
    $estado = "no_encontrado";
}

$eliminar->close();
$conexion->close();

header("Location: listar.php?estado=eliminado" );
exit();

?>