<?php

session_start();

include( "conexion.php" );

if( $_SERVER[ "REQUEST_METHOD" ] !== "POST" ) {

    // die( "Metodo de solicitud no permitido" );
    header( "Location: listar.php" );
    exit();

}

$id = filter_input( INPUT_POST, "id", FILTER_VALIDATE_INT );
$nombre = trim( $_POST[ "nombre" ] ?? "" );
$apellido = trim( $_POST["apellido"] ?? "" );
$correo = trim($_POST["correo"] ?? "");
$edad = filter_input(INPUT_POST, "edad", FILTER_VALIDATE_INT);
$programa = trim($_POST["programa"] ?? "");

if( $id === false || $id === null ){
    die( "Error: identificador no valido." );
}

if (
    !$id ||
    $nombre === "" ||
    $apellido === "" ||
    $correo === "" ||
    $edad === false ||
    $edad === null ||
    $programa === ""
) {
    $_SESSION[ "notificacion" ] = [
        "tipo" => "error",
        "mensaje" => "Por favor, verificar todos los datos ingresados."
    ];

    header( "Location: listar.php" );
    exit();
}

$actualizar = $conexion->prepare(
    "UPDATE estudiantes SET nombre = ?, apellido = ?, correo = ?, edad = ?, programa = ? WHERE id = ?"
);

$actualizar->bind_param( "sssisi", $nombre, $apellido, $correo, $edad, $programa, $id );
$actualizar->execute();

if( $actualizar->affected_rows > 0 ){
    $_SESSION[ "notificacion" ] = [
        "tipo" => "exito",
        "mensaje" => "Registro actualizado exitosamente."
    ];

} else {
    $_SESSION[ "notificacion" ] = [
        "tipo" => "info",
        "mensaje" => "No hubo cambios o el usuario no existe."
    ];
}

$actualizar->close();
$conexion->close();

header( "Location: listar.php" );
exit();

?>