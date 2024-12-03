<?php
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

// Conexión a la base de datos
$servername = "161.35.224.168";
$username = "dev1";
$password = "ESIS_2024_dev1";
$dbname = "esis-farmacia";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Registrar cliente
if (isset($_POST['registrar_cliente'])) {
    $nombre = $_POST['nombre_cliente'];
    $dni = $_POST['dni_cliente'];
    $contacto = !empty($_POST['contacto_cliente']) ? $_POST['contacto_cliente'] : null;

    $stmt = $pdo->prepare("INSERT INTO cliente (nombre_cliente, DNI, contacto) VALUES (:nombre, :dni, :contacto)");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':contacto', $contacto);

    if ($stmt->execute()) {
        echo "Cliente registrado correctamente.<br>";
    } else {
        echo "Error al registrar el cliente.<br>";
    }
}

// Registrar factura y productos
if (isset($_POST['registrar_factura'])) {
    try {
        $pdo->beginTransaction(); // Iniciar una transacción

        // Insertar la factura en la tabla ventas
        $codigo = $_POST['codigo_factura'];
        $fecha = $_POST['fecha_factura'];
        $id_cliente = $_POST['id_cliente'];

        $stmt = $pdo->prepare("INSERT INTO ventas (codigo, fecha_venta, Cliente_idCliente) VALUES (:codigo, :fecha, :id_cliente)");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();

        // Obtener el ID de la factura recién creada
        $id_venta = $pdo->lastInsertId();

        // Insertar los productos en la tabla detalleventas
        foreach ($_POST['productos'] as $index => $id_producto) {
            $cantidad = $_POST['cantidades'][$index];

            $stmt = $pdo->prepare("INSERT INTO detalleventas (cantidad, Ventas_idVentas, productos_id) VALUES (:cantidad, :id_venta, :id_producto)");
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':id_venta', $id_venta);
            $stmt->bindParam(':id_producto', $id_producto);
            $stmt->execute();
        }

        $pdo->commit(); // Confirmar la transacción
        echo "Factura y productos registrados correctamente.<br>";
    } catch (Exception $e) {
        $pdo->rollBack(); // Revertir la transacción en caso de error
        echo "Error al registrar la factura: " . $e->getMessage() . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Medicamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link href="../../../public/css/venta.css.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php include('../head1.php'); ?>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="main-content">
                    <h1>Registrar Cliente</h1>
                    <form method="POST">
                        <label for="nombre_cliente">Nombre del Cliente:</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" required>
                        <br>
                        <label for="dni_cliente">DNI:</label>
                        <input type="text" id="dni_cliente" name="dni_cliente" required>
                        <br>
                        <label for="contacto_cliente">Contacto (Opcional):</label>
                        <input type="text" id="contacto_cliente" name="contacto_cliente">
                        <br>
                        <button type="submit" name="registrar_cliente">Registrar Cliente</button>
                    </form>

                    <h1>Registrar Factura y Productos</h1>
                    <form method="POST">
                        <label for="codigo_factura">Código de la Factura:</label>
                        <input type="text" id="codigo_factura" name="codigo_factura" required>
                        <br>
                        <label for="fecha_factura">Fecha de la Factura:</label>
                        <input type="datetime-local" id="fecha_factura" name="fecha_factura" required>
                        <br>
                        <label for="id_cliente">Cliente:</label>
                        <select id="id_cliente" name="id_cliente" required>
                            <?php
                            // Obtener los clientes registrados
                            $stmt = $pdo->query("SELECT idCliente, nombre_cliente FROM cliente");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['idCliente'] . "'>" . $row['nombre_cliente'] . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <h2>Productos</h2>
                        <div id="productos-contenedor">
                            <div>
                                <label for="producto">Producto:</label>
                                <select name="productos[]" onchange="actualizarCostoTotal()" required>
                                    <?php
                                    // Obtener los productos registrados
                                    $stmt = $pdo->query("SELECT id, Nombreproducto, precio FROM productos");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row['id'] . "' data-precio='" . $row['precio'] . "'>" . $row['Nombreproducto'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" name="cantidades[]" min="1" onchange="actualizarCostoTotal()" required>
                            </div>
                        </div>
                        <button type="button" onclick="agregarProducto()">Agregar otro producto</button>
                        <br><br>
                        <div>
                            <label for="costo_total">Costo Total:</label>
                            <input type="text" id="costo_total" name="costo_total" readonly>
                        </div>
                        <button type="submit" name="registrar_factura">Registrar Factura</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>

<script>
    // Función para agregar más campos de productos dinámicamente
    function agregarProducto() {
        const contenedor = document.getElementById('productos-contenedor');
        const nuevoProducto = `
            <div>
                <label for="producto">Producto:</label>
                <select name="productos[]" onchange="actualizarCostoTotal()" required>
                    <?php
                    // Obtener los productos registrados
                    $stmt = $pdo->query("SELECT id, Nombreproducto, precio FROM productos");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['id'] . "' data-precio='" . $row['precio'] . "'>" . $row['Nombreproducto'] . "</option>";
                    }
                    ?>
                </select>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidades[]" min="1" onchange="actualizarCostoTotal()" required>
            </div>
        `;
        contenedor.innerHTML += nuevoProducto;
    }

    // Función para calcular el costo total dinámicamente
    function actualizarCostoTotal() {
        const productos = document.querySelectorAll('select[name="productos[]"]');
        const cantidades = document.querySelectorAll('input[name="cantidades[]"]');
        let costoTotal = 0;

        productos.forEach((producto, index) => {
            const precio = producto.options[producto.selectedIndex].getAttribute('data-precio');
            const cantidad = cantidades[index].value;

            if (precio && cantidad) {
                costoTotal += parseFloat(precio) * parseInt(cantidad);
            }
        });

        document.getElementById('costo_total').value = costoTotal.toFixed(2);
    }
</script>
