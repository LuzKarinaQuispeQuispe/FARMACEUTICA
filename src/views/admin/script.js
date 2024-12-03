document.getElementById('guardar-cliente').addEventListener('click', () => {
    const nombre_cliente = document.getElementById('nombre_cliente').value;
    const celular = document.getElementById('celular').value;
    const dni = document.getElementById('dni').value;

    fetch('agregar_cliente.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `nombre_cliente=${nombre_cliente}&celular=${celular}&dni=${dni}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cliente registrado con éxito');
            document.getElementById('cliente-form').style.display = 'none';
            document.getElementById('venta-form').style.display = 'block';
            document.getElementById('guardar-venta').dataset.clienteId = data.cliente_id;
        } else {
            alert('Error al registrar el cliente: ' + data.message);
        }
    });
});

document.getElementById('guardar-venta').addEventListener('click', () => {
    const codigo = document.getElementById('codigo').value;
    const fecha = document.getElementById('fecha').value;
    const cliente_id = document.getElementById('guardar-venta').dataset.clienteId;

    fetch('agregar_ventas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `codigo=${codigo}&fecha=${fecha}&cliente_id=${cliente_id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Venta registrada con éxito');
            location.reload();
        } else {
            alert('Error al registrar la venta: ' + data.message);
        }
    });
});
