<?php

session_start();

include("conexion.php");

if( $_SERVER[ "REQUEST_METHOD" ] !== "POST" ) {

    // die( "Metodo de solicitud no permitido" );
    header( "Location: listar.php" );
    exit();
}

$nombre = trim( $_POST['nombre'] ?? "");
$apellido = trim( $_POST['apellido'] ?? "");
$documento = trim( $_POST['documento'] ?? "");
$edadRecibida = trim( $_POST['edad'] ?? "");
$correo = trim( $_POST['correo'] ?? "");
$fechaNacimiento = trim( $_POST['fechaNacimiento'] ?? "");
$programa = trim( $_POST['programa'] ?? "" );

if( $nombre === "" ||
    $apellido === "" ||
    $documento === "" ||
    $edadRecibida === "" ||
    $correo === "" ||
    $fechaNacimiento === "" ||
    $programa === "" ){
    
    header("Location: index.php?estado=datos_invalidos");
    exit();
}

if( !filter_var( $correo, FILTER_VALIDATE_EMAIL ) ){
    
    header("Location: index.php?estado=correo_invalido");
    exit();
}

$edad = filter_var(
    $edadRecibida,
    FILTER_VALIDATE_INT,
    [
        "options" => [
            "min_range" => 1,
            "max_range" => 100
        ]
    ]
);

if( $edad === false ){

    header("Location: index.php?estado=edad_invalida");
    exit();

}

$programaPermitidos = [
    "Ingeniería Informática",
    "Ingeniería Industrial",
    "Administración de Empresass"
];

if( !in_array( $programa, $programaPermitidos, true ) ){
    header("Location: index.php?estado=programa_invalido");
    exit();
    
}

$consulta = $conexion->prepare( 
    "SELECT id FROM estudiantes WHERE correo = ?"
);

$consulta->bind_param( "s", $correo );
$consulta->execute();
$consulta->store_result();

if( $consulta->num_rows > 0 ){
    
    header("Location: index.php?estado=correo_repetido");
    exit();

}

$consulta->close();

$insert = $conexion->prepare(
    "INSERT INTO estudiantes (ID, nombre, apellido, edad, correo, fecha, programa)
    VALUES (?, ?, ?, ?, ?, ?, ?)"
);

$insert->bind_param(
    "ississs",
    $documento,
    $nombre,
    $apellido,
    $edad,
    $correo,
    $fechaNacimiento,
    $programa
);

if( $insert->execute() ){


    

    header("Location: index.php?estado=guardado");
    exit();

} else {

    header("Location: index.php?estado=error_guardar");
    exit();
}

?>