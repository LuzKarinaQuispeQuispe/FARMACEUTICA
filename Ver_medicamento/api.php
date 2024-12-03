<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "161.35.224.168";
$username = "dev1";
$password = "ESIS_2024_dev1";
$dbname = "esis-farmacia";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Acción para obtener detalles de una venta específica
if ($_GET['action'] === 'getSaleDetailsByCode' && isset($_GET['codigo'])) {
    $codigo = $conn->real_escape_string($_GET['codigo']);
    $query = "
        SELECT 
            dv.productos_id AS id, 
            p.Nombreproducto AS nombre_producto, 
            p.precio,
            JSON_OBJECT(
                'cantidad', dv.cantidad,
                'via_suministro', m.via_suministro,
                'forma', m.forma,
                'atc', m.atc,
                'riesgo', m.riesgo,
                'mecanismo', m.mecanismo,
                'indicaciones', m.indicaciones,
                'posologia', m.posologia,
                'contraindicaciones', m.contraindicaciones,
                'advertencias_precausiones', m.advertencias_precausiones
            ) AS medicamento_info
        FROM detalleventas dv
        INNER JOIN ventas v ON dv.Ventas_idVentas = v.idVentas
        INNER JOIN productos p ON dv.productos_id = p.id
        LEFT JOIN medicamentos m ON p.medicamentos_id = m.id
        WHERE v.codigo = '$codigo'
    ";
    
    $result = $conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}

$conn->close();
?>
