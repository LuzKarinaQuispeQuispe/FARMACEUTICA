
<?php
session_start();
if (!isset($_SESSION['rol_1'])) { 
    header('location: ../login.php');
    exit();
}
?>

<?php
include_once '../../../config/conection.php';
$database = new Database();
$conn = $database->getConnection();

// Consultas para obtener los datos necesarios

// Total de productos
$queryProductos = "SELECT COUNT(*) AS total FROM productos";
$stmtProductos = $conn->prepare($queryProductos);
$stmtProductos->execute();
$totalProductos = $stmtProductos->fetch(PDO::FETCH_ASSOC)['total'];

// Total de productos vendidos
$queryProductosVendidos = "SELECT SUM(CAST(dv.cantidad AS UNSIGNED)) AS total FROM detalleventas dv";
$stmtProductosVendidos = $conn->prepare($queryProductosVendidos);
$stmtProductosVendidos->execute();
$totalProductosVendidos = $stmtProductosVendidos->fetch(PDO::FETCH_ASSOC)['total'];

// Total de ventas
$queryVentas = "SELECT COUNT(*) AS total FROM ventas";
$stmtVentas = $conn->prepare($queryVentas);
$stmtVentas->execute();
$totalVentas = $stmtVentas->fetch(PDO::FETCH_ASSOC)['total'];

// Total de proveedores
$queryProveedores = "SELECT COUNT(*) AS total FROM proveedores";
$stmtProveedores = $conn->prepare($queryProveedores);
$stmtProveedores->execute();
$totalProveedores = $stmtProveedores->fetch(PDO::FETCH_ASSOC)['total'];

// Total de productos vencidos
$queryProductosVencidos = "SELECT COUNT(*) AS total FROM productos WHERE fecha_vencimiento < NOW()";
$stmtProductosVencidos = $conn->prepare($queryProductosVencidos);
$stmtProductosVencidos->execute();
$totalProductosVencidos = $stmtProductosVencidos->fetch(PDO::FETCH_ASSOC)['total'];

$queryProductosMasVendidos = "
    SELECT p.Nombreproducto, SUM(CAST(dv.cantidad AS UNSIGNED)) AS cantidad_vendida
    FROM detalleventas dv
    JOIN productos p ON dv.productos_id = p.id
    GROUP BY p.Nombreproducto
    ORDER BY cantidad_vendida DESC
    LIMIT 5;
";
$stmtProductosMasVendidos = $conn->prepare($queryProductosMasVendidos);
$stmtProductosMasVendidos->execute();
$productosMasVendidos = $stmtProductosMasVendidos->fetchAll(PDO::FETCH_ASSOC);

// Preparamos los datos para la gráfica
$productNames = [];
$productSales = [];
foreach ($productosMasVendidos as $producto) {
    $productNames[] = $producto['Nombreproducto'];
    $productSales[] = $producto['cantidad_vendida'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/graficos.css">
    <link rel="stylesheet" href="../../../public/css/principal.css">
    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php include('../head1.php'); ?>
</head>
<body class="sb-nav-fixed">

    <div id="layoutSidenav">
        <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="main-content">
                    <!-- Tarjetas con estadísticas -->
                    <div class="cards">
                        <!-- Card 1: Productos -->
                        <div class="card card-productos">
                            <i class="fas fa-cogs card-icon"></i>
                            <div class="card-content">
                                <h3>Total Productos</h3>
                                <p><?php echo $totalProductos; ?></p>
                            </div>
                        </div>
                        <!-- Card 2: Productos Vendidos -->
                        <div class="card card-productos-vendidos">
                            <i class="fas fa-box-open card-icon"></i>
                            <div class="card-content">
                                <h3>Total Productos Vendidos</h3>
                                <p><?php echo $totalProductosVendidos; ?></p>
                            </div>
                        </div>
                        <!-- Card 3: Ventas -->
                        <div class="card card-ventas">
                            <i class="fas fa-chart-line card-icon"></i>
                            <div class="card-content">
                                <h3>Total Ventas</h3>
                                <p><?php echo $totalVentas; ?></p>
                            </div>
                        </div>
                        <!-- Card 4: Proveedores -->
                        <div class="card card-proveedores">
                            <i class="fas fa-truck card-icon"></i>
                            <div class="card-content">
                                <h3>Total Proveedores</h3>
                                <p><?php echo $totalProveedores; ?></p>
                            </div>
                        </div>
                        <!-- Card 5: Productos Vencidos -->
                        <div class="card card-productos-vencidos">
                            <i class="fas fa-calendar-times card-icon"></i>
                            <div class="card-content">
                                <h3>Productos Vencidos</h3>
                                <p><?php echo $totalProductosVencidos; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gráfica de los 5 productos más vendidos -->
                    <div class="chart-container">
                        <h4>Top 5 Productos Más Vendidos</h4>
                        <canvas id="productosMasVendidosChart"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/graficos.js"></script>
    <script>
        // Datos para la gráfica de barras
        const productNames = <?php echo json_encode($productNames); ?>;
        const productSales = <?php echo json_encode($productSales); ?>;

        // Configuración de la gráfica
        const ctx = document.getElementById('productosMasVendidosChart').getContext('2d');
        const productosMasVendidosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: productSales,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Color de las barras
                    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
