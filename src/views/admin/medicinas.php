<?php
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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Medicamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php include('../head.php'); ?>
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
                    <div class="contenedor">
                        <h2>Medicamentos</h2>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="thfiltro" id="nombrefiltro" data-order="asc" data-field="nombre"><span class="header-text">Nombre</span> <i id="nombrefilter" class="fas fa-sort"></i></th>
                                <th class="thfiltro" id="cantidadfiltro" data-order="asc" data-field="cantidad"><span class="header-text">Cantidad</span> <i id="cantidadfilter" class="fas fa-sort"></i></th>
                                <th class="thfiltro" id="via_suministrofiltro" data-order="asc" data-field="via_suministro"><span class="header-text">Vía de Suministro</span> <i id="via_suministrofilter" class="fas fa-sort"></i></th>
                                <th>Modificar</th>
                            </tr>
                        </thead>
                        <tbody id="contenidoTabla">
                            <!-- Aquí se agregarán las filas de la tabla dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
