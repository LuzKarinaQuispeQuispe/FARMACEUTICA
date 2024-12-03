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
                    <div class="contenedor">
                        <h2>Medicamentos</h2>
                        <div class="input-group">
                            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                            <input class="form-control" type="text" id="searchMedicamento" placeholder="Buscar medicamento..." />
                        </div>
                        <div><button class="boton_agregar" id="btnAgregarMedicamento">Agregar</button></div>
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

                <!-- Modal de Agregar y Editar Medicamento -->
                <div id="myModal" class="modal" data-id="">
                    <div class="modal-content">
                        <div class="horizontal">
                            <h2 id="modalTitle">Agregar Medicamento</h2>
                            <span class="close">&times;</span>
                        </div>
                        <form class="row gy-2 gx-3 align-items-center" id="formAgregarMedicamento">
                            <!-- Agregamos el campo para ingresar el 'id' manualmente -->
                            <div class="col-auto">
                                <label for="idMedicamento" class="visually-hidden">Código (ID)</label>
                                <input type="number" class="form-control" id="idMedicamento" placeholder="Código (ID)" required>
                            </div>
                            <div class="col-auto">
                                <label for="nombreMedicamento" class="visually-hidden">Nombre</label>
                                <input type="text" class="form-control" id="nombreMedicamento" placeholder="Nombre" required>
                            </div>
                            <div class="col-auto">
                                <label for="cantidadMedicamento" class="visually-hidden">Cantidad</label>
                                <input type="text" class="form-control" id="cantidadMedicamento" placeholder="Cantidad" required>
                            </div>
                            <div class="col-auto">
                                <label for="viaSuministroMedicamento" class="visually-hidden">Vía de Suministro</label>
                                <input type="text" class="form-control" id="viaSuministroMedicamento" placeholder="Vía de Suministro" required>
                            </div>
                            <div class="submit-btn-edit">
                                <button type="submit" class="btn btn-primary">Guardar Medicamento</button>
                                <button type="button" class="btncancelar" id="btnformcancelarAdd">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
