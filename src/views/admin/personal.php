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
        <title>Agregar empleado</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../../../public/css/principal.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <?php include('../head1.php'); ?> 
        
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        
        <div id="layoutSidenav">
            <!-- Incluir el sidebar -->
            <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="main-content">
                        <div class="contenedor">
                            <div><h2>Usuario</h2></div>
                            <div class="input-group">
                                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                                <input class="form-control" type="text" placeholder="Buscar" aria-label="Buscar..." aria-describedby="btnNavbarSearch" />
                                
                            </div>
                            <div><button class="boton_agregar" id="btnAgregar">Agregar</button></div>
                            
                        </div>
                        <div class="formulario_producto" id="formularioProducto">
                            
                            <p>Ingresa datos</p>
                            <div>
                            <div class="d-flex">
                                <form class="row gy-2 gx-3 align-items-center" id="formProducto">
                                    <div class="col-auto">
                                        <label class="visually-hidden" for="autoSizingInput">Nombre</label>
                                        <input type="text" class="form-control" id="autoSizingInputnombre" placeholder="Nombre">
                                    </div>
                                    <div class="col-auto">
                                        <label class="visually-hidden" for="autoSizingInput">Usuario</label>
                                        <input type="text" class="form-control" id="autoSizingInputprecio" placeholder="Usuario">
                                    </div>
                                    <div class="col-auto">
                                        <label class="visually-hidden" for="autoSizingInput">Contraseña</label>
                                        <input type="password" class="form-control" id="autoSizingInputPassword" placeholder="Contraseña">
                                    </div>
                                    
                                    <div class="col-auto">
                                        <label class="visually-hidden" for="autoSizingInput">Confirmar contraseña</label>
                                        <input type="password" class="form-control" id="autoSizingInputConfirmPassword" placeholder="Confirmar contraseña">
                                    </div>
                                    
                                    <div class="col-auto">
                                        <label class="visually-hidden" for="autoSizingSelect">Categoria</label>
                                        <select class="form-select" id="autoSizingSelectcat">Categoria
                                        <option selected disabled hidden>Categoria</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Stock</option>
                                        <option value="3">Ventas</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>

                                        <div class="col-auto">
                                            <button type="button" class="btnreiniciar" id="btnformreiniciar">Reiniciar</button>
                                        </div>

                                        <div class="col-auto">
                                            <button type="button" class="btncancelar" id="btnformcancelar">Cancelar</button>
                                        </div>  
                                </form>
                                </div>
                            </div>
                            
                            
                        </div>
                        
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="thfiltro" id="Nombrefiltro" data-order="asc" data-field="nombre"><span class="header-text">Nombre</span> <i id="nombrefilter" class="fas fa-sort"></i></th>
                                        <th class="thfiltro" id="Preciofiltro" data-order="asc" data-field="precio"><span class="header-text">Usuario</span> <i id="preciofilter" class="fas fa-sort"></i></th>
                                        <th class="thfiltro" id="Categoriafiltro" data-order="asc" data-field="categoria"><span class="header-text">Categoría</span> <i id="categoriafilter" class="fas fa-sort" ></i></th>
                                        <th>Modificar</th>
                                    </tr>
                                </thead>
                                <tbody id="contenidoTabla">
                                    <!-- Aquí se agregarán las filas de la tabla dinámicamente con JavaScript -->
                                </tbody>
                            </table>
                            
                            <!-- Agregar elementos de paginación -->
                            <div class="pagination">
                                <button id="previousPage">Anterior</button>
                                <span id="pageInfo">Página <span id="currentPage">1</span> de <span id="totalPages">1</span></span>
                                <button id="nextPage">Siguiente</button>
                                <select id="itemsPerPage">
                                    <option value="5">5 por página</option>
                                    <option value="10" selected>10 por página</option>
                                    <option value="20">20 por página</option>
                                    <option value="50">50 por página</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div id="myModal" class="modal" data-id="">
                    
                        <div class="modal-content">
                            <div class="horizontal">
                                <h2>Editar Usuario</h2>
                                <span class="close">&times;</span>
                            </div>
                            <!-- Formulario de edición -->
                            <div class="editForm">
                                <form class="row gy-2 gx-3 align-items-center" id="formEditarProducto">
                                    <div class="col-auto">
                                        <p class="p-modal">Nombre</p>
                                        <label class="visually-hidden" for="autoSizingInput"></label>
                                        <input type="text" class="form-control" id="autoSizingInputnombreEditar" placeholder="Nombre">
                                    </div>
                                    <div class="col-auto">
                                        <p class="p-modal">Usuario</p>
                                        <label class="visually-hidden" for="autoSizingInput"></label>
                                        <input type="text" class="form-control" id="autoSizingInputprecioEditar" placeholder="Usuario">
                                    </div>

                                    <div class="col-auto">
                                        <p class="p-modal">Contraseña</p>
                                        <label class="visually-hidden" for="autoSizingInput"></label>
                                        <input type="password" class="form-control" id="autoSizingInputPasswordEditar" placeholder="Contraseña">
                                    </div>
                                    
                                    <div class="col-auto">
                                         <p class="p-modal">Confirmar contraseña</p>
                                        <label class="visually-hidden" for="autoSizingInput"></label>
                                        <input type="password" class="form-control" id="autoSizingInputConfirmPasswordEditar" placeholder="Confirmar contraseña">
                                    </div>
                                    
                                    <div class="col-auto">
                                        <p class="p-modal">Categoria</p>
                                        <label class="visually-hidden" for="autoSizingSelect"></label>
                                        <select class="form-select" id="autoSizingSelectcatEditar">
                                            <option selected disabled hidden>Categoria</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Stock</option>
                                            <option value="3">ventas</option>
                                        </select>
                                    </div>
                                    <div class="submit-btn-edit">
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    
                                        <button type="button" class="btncancelar" id="btnformcancelarEdit">Cancelar</button>
                                    </div>  
                                </form>
                            </div>
                            
                        </div>
                    </div>

                    
                </main>
                
            </div>
            
        <script src="../../../public/js/usuario.js"></script>
        
        </body>
</html>

