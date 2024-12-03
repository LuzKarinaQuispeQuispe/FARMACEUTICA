<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Cliente y Venta</title>
    <style>
        .input-field {
            margin: 10px 0;
            padding: 8px;
            font-size: 14px;
            width: 100%;
        }
        .readonly {
            background-color: #f0f0f0;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .form-container {
            width: 500px;
            margin: 20px auto;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .button:disabled {
            background-color: #d3d3d3;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <h2>Datos del Cliente</h2>

    <div class="form-container">
        <!-- Formulario para Cliente -->
        <div id="formCliente">
            <h3>Datos del Cliente</h3>
            <form id="clienteForm">
                <div class="form-section">
                    <label for="nombre_cliente">Nombre Cliente:</label>
                    <input type="text" id="nombre_cliente" name="nombre_cliente" class="input-field" value="Alexandra">
                </div>
                <div class="form-section">
                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" name="celular" class="input-field" value="983023528">
                </div>
                <div class="form-section">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" class="input-field" value="73008057">
                </div>
            </form>
            <button class="button" id="guardarClienteBtn">Guardar Cliente</button>
        </div>

        <!-- Formulario para Venta -->
        <div id="formVenta" style="margin-top: 40px;">
            <h3>Datos de la Venta</h3>
            <form id="ventaForm">
                <div class="form-section">
                    <label for="codigo_venta">Código de Venta:</label>
                    <input type="text" id="codigo_venta" name="codigo_venta" class="input-field" disabled>
                </div>
                <div class="form-section">
                    <label for="fecha_venta">Fecha de Venta:</label>
                    <input type="datetime-local" id="fecha_venta" name="fecha_venta" class="input-field" disabled>
                </div>
            </form>
            <button class="button" id="guardarVentaBtn" disabled>Guardar Venta</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let isClienteGuardado = false;
        let clienteId = null;

        // Guardar Cliente en la base de datos
        document.getElementById('guardarClienteBtn').addEventListener('click', function() {
            // Obtener los datos del cliente
            const nombre_cliente = document.getElementById('nombre_cliente').value;
            const celular = document.getElementById('celular').value;
            const dni = document.getElementById('dni').value;

            // Enviar los datos a través de AJAX
            $.ajax({
                url: 'guardar_cliente.php',
                type: 'POST',
                data: { nombre_cliente, celular, dni },
                success: function(response) {
                    const json = JSON.parse(response);
                    if (json.success) {
                        clienteId = json.cliente_id; // Obtener el ID del cliente guardado
                        alert('Cliente guardado con éxito!');
                        
                        // Deshabilitar campos de cliente y habilitar campos de venta
                        document.getElementById('nombre_cliente').disabled = true;
                        document.getElementById('celular').disabled = true;
                        document.getElementById('dni').disabled = true;
                        document.getElementById('guardarClienteBtn').disabled = true;

                        document.getElementById('codigo_venta').disabled = false;
                        document.getElementById('fecha_venta').disabled = false;
                        document.getElementById('guardarVentaBtn').disabled = false;
                    } else {
                        alert('Error al guardar el cliente: ' + json.message);
                    }
                },
                error: function() {
                    alert('Error al enviar datos del cliente.');
                }
            });
        });

        // Guardar Venta en la base de datos
        document.getElementById('guardarVentaBtn').addEventListener('click', function() {
            // Obtener los datos de la venta
            const codigo_venta = document.getElementById('codigo_venta').value;
            const fecha_venta = document.getElementById('fecha_venta').value;

            if (clienteId) {
                // Enviar los datos de la venta y el ID del cliente a través de AJAX
                $.ajax({
                    url: 'guardar_venta.php',
                    type: 'POST',
                    data: { codigo_venta, fecha_venta, cliente_id: clienteId },
                    success: function(response) {
                        const json = JSON.parse(response);
                        if (json.success) {
                            alert('Venta guardada con éxito!');
                        } else {
                            alert('Error al guardar la venta: ' + json.message);
                        }
                    },
                    error: function() {
                        alert('Error al enviar datos de la venta.');
                    }
                });
            }
        });
    </script>

</body>
</html>

