<?php
header("Content-Type: application/json; charset=UTF-8");

include("conexion.php");

if (!isset($conexion) || $conexion->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "No fue posible conectar con la base de datos."]);
    exit;
}

$nombre = trim($_GET["nombre"] ?? "");
$apellido = trim($_GET["apellido"] ?? "");
$correo = trim($_GET["correo"] ?? "");
$programa = trim($_GET["programa"] ?? "");
$documento = trim($_GET["documento"] ?? "");
$orden = strtoupper($_GET["orden"] ?? "ASC");

if (!in_array($orden, ["ASC", "DESC"], true)) {
    $orden = "ASC";
}

$sql = "SELECT ID, nombre, apellido, edad, correo, programa
        FROM estudiantes
        WHERE (? = '' OR nombre LIKE ?)
          AND (? = '' OR apellido LIKE ?)
          AND (? = '' OR correo LIKE ?)
          AND (? = '' OR programa LIKE ?)
          AND (? = '' OR CAST(ID AS CHAR) LIKE ?)
        ORDER BY nombre $orden";

$consulta = $conexion->prepare($sql);

if (!$consulta) {
    http_response_code(500);
    echo json_encode(["error" => "No fue posible preparar la consulta."]);
    $conexion->close();
    exit;
}

$nombreBusqueda = "%" . $nombre . "%";
$apellidoBusqueda = "%" . $apellido . "%";
$correoBusqueda = "%" . $correo . "%";
$programaBusqueda = "%" . $programa . "%";
$documentoBusqueda = "%" . $documento . "%";

$consulta->bind_param(
    "ssssssssss",
    $nombre, $nombreBusqueda,
    $apellido, $apellidoBusqueda,
    $correo, $correoBusqueda,
    $programa, $programaBusqueda,
    $documento, $documentoBusqueda
);

if (!$consulta->execute()) {
    http_response_code(500);
    echo json_encode(["error" => "No fue posible consultar los estudiantes."]);
    $consulta->close();
    $conexion->close();
    exit;
}

$resultado = $consulta->get_result();
$estudiantes = [];

while ($fila = $resultado->fetch_assoc()) {
    $estudiantes[] = $fila;
}

echo json_encode($estudiantes, JSON_UNESCAPED_UNICODE);

$consulta->close();
$conexion->close();
?>
