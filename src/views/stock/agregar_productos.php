<?php
// Incluir la conexión a la base de datos
include('../../../config/conection.php');

// Crear una instancia de la clase Database
$database = new Database();
$conn = $database->getConnection();

// Obtener las categorías desde la base de datos
$query = "SELECT idCategorias, nombre FROM categorias";
$stmt = $conn->prepare($query);
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener los productos con solo las columnas necesarias
$query_productos = "
    SELECT 
        p.Nombreproducto,
        p.precio,
        p.ubicacion_farmacia,
        p.fecha_vencimiento
    FROM productos p
";
$stmt_productos = $conn->prepare($query_productos);
$stmt_productos->execute();
$productos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);

session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link href="../../../public/css/productos.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#form-agregar-producto').on('submit', function (e) {
                e.preventDefault(); // Evita el envío tradicional del formulario

                const formData = $(this).serialize(); // Serializa los datos del formulario

                $.post('guardar_producto.php', formData, function () {
                    location.reload(); // Recarga la página tras guardar el producto
                }).fail(function () {
                    console.error('Error al guardar el producto.');
                });
            });
        });

        function abrirVentanaMedicamentos() {
            const ventana = window.open("selecciona_medicamentos.php", "Medicamentos", "width=800,height=600");
            ventana.focus();
        }

        function seleccionarMedicamento(nombreCantidad, medicamentoId) {
            document.getElementById('Nombreproducto').value = nombreCantidad;
            document.getElementById('medicamentos_id').value = medicamentoId;
        }
    </script>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="main-content">
                    

                    <!-- Formulario para agregar producto -->
                    <form id="form-agregar-producto">
                    <h2>Agregar Producto</h2>
                        <label for="Nombreproducto">Nombre Producto:</label>
                        <input type="text" id="Nombreproducto" name="Nombreproducto" required>
                        <button type="button" onclick="abrirVentanaMedicamentos()">🔍</button>
                        <br><br>

                        <label for="precio">Precio Unitario:</label>
                        <input type="number" id="precio" name="precio" step="0.01" required>
                        <br><br>

                        <label for="cantidad_de_cajas">Cantidad de Cajas:</label>
                        <input type="number" id="cantidad_de_cajas" name="cantidad_de_cajas" required>
                        <br><br>

                        <label for="cantidad_por_caja">Cantidad por Caja:</label>
                        <input type="number" id="cantidad_por_caja" name="cantidad_por_caja" required>
                        <br><br>

                        <label for="ubicacion_farmacia">Ubicación:</label>
                        <input type="text" id="ubicacion_farmacia" name="ubicacion_farmacia" required>
                        <br><br>

                        <label for="Categorias_idCategorias">Categoría:</label>
                        <select id="Categorias_idCategorias" name="Categorias_idCategorias" required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['idCategorias'] ?>"><?= $categoria['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>

                        <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" required>
                        <br><br>

                        <input type="hidden" id="medicamentos_id" name="medicamentos_id">
                        <input type="hidden" name="fecha_ingreso" value="<?= date('Y-m-d H:i:s') ?>">
                        <button type="submit">Guardar Producto</button>
                    </form>

                    <hr>

                    <!-- Tabla de Productos Registrados -->
                    
                    <table class="table table-striped table-bordered mt-4">
                    
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre del Producto</th>
                                <th>Precio</th>
                                <th>Ubicación</th>
                                <th>Fecha de Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($productos)): ?>
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($producto['Nombreproducto']) ?></td>
                                        <td>S/ <?= number_format($producto['precio'], 2) ?></td>
                                        <td><?= htmlspecialchars($producto['ubicacion_farmacia']) ?></td>
                                        <td><?= htmlspecialchars($producto['fecha_vencimiento']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay productos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
