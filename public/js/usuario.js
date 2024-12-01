let filtroDataAdded = false; 
let productosData; 
document.addEventListener('DOMContentLoaded', function() {
    setupEventListeners();
    initializePage();
});


//obtiene los elementos y les agrega las funciones de eventos

function setupEventListeners() {
    document.getElementById('btnAgregar').addEventListener('click', toggleFormVisibility);
    document.getElementById('formProducto').addEventListener('submit', handleFormSubmit);
    document.getElementById('previousPage').addEventListener('click', goToPreviousPage);
    document.getElementById('nextPage').addEventListener('click', goToNextPage);
    document.getElementById('itemsPerPage').addEventListener('change', handleItemsPerPageChange);
    document.querySelector('.form-control').addEventListener('input', handleSearchInput);
    document.getElementById('btnformreiniciar').addEventListener('click', vaciarFormulario);
    document.getElementById('btnformcancelar').addEventListener('click', toggleFormVisibility);
    document.getElementById('btnformcancelarEdit').addEventListener('click',cerrarModalEdicion );

}


// muestra y oculta el toggleForm
function toggleFormVisibility() {
    restaurarTheme();
    document.getElementById('formularioProducto').classList.toggle('mostrar');
}
//Maneja el envio de formulario
function handleFormSubmit(event) {
    event.preventDefault();
    const producto = getFormData();

    if (producto){
        enviarProducto(producto);
        vaciarFormulario();
    }
    
}
//restaurar el formato anterior al manejo de error de edicion
function restaurarThemeEdit(){
    const nombreInput = document.getElementById('autoSizingInputnombreEditar');
    const usuarioInput = document.getElementById('autoSizingInputprecioEditar');
    const contraInput = document.getElementById('autoSizingInputPasswordEditar');
    const contra2Input = document.getElementById('autoSizingInputConfirmPasswordEditar');
    const categoriaInput = document.getElementById('autoSizingSelectcatEditar');

    
    nombreInput.style.borderColor = ''; // Restablecer el borde a su color normal
    usuarioInput.style.borderColor = ''; // Restablecer el borde a su color normal
    contraInput.style.borderColor = ''; // Restablecer el borde a su color normal
    contra2Input.style.borderColor = ''; // Restablecer el borde a su color normal
    categoriaInput.style.borderColor = ''; // Restablecer el borde a su color normal

};
//restaurar el formato anterior al manejo de error envio
function restaurarTheme(){
    const nombreInput = document.getElementById('autoSizingInputnombre');
    const usuarioInput = document.getElementById('autoSizingInputprecio');
    const contraInput = document.getElementById('autoSizingInputPassword');
    const contra2Input = document.getElementById('autoSizingInputConfirmPassword');
    const categoriaInput = document.getElementById('autoSizingSelectcat');
   
    categoriaInput.style.borderColor = ''; // Restablecer el borde a su color normal

    contra2Input.style.borderColor = ''; // Restablecer el borde a su color normal

    
    contraInput.style.borderColor = ''; // Restablecer el borde a su color normal

    usuarioInput.style.borderColor = ''; // Restablecer el borde a su color normal

    nombreInput.style.borderColor = ''; // Restablecer el borde a su color normal

    
};
//Vacia el formulario de envio de item
function vaciarFormulario() {
    restaurarTheme();
    document.getElementById('formProducto').reset();
}
//obtiene el formato de los elementos del formulario y se realiza una validacion
function getFormData() {
    const errors = []; // Array para almacenar los errores

    const regex = /^[a-zA-Z\s]*$/;

    const nombreInput = document.getElementById('autoSizingInputnombre');
    let nombre = nombreInput.value.trim();

    if (nombre === '') {
        errors.push('El campo de nombre no puede estar vacío.');
        nombreInput.style.borderColor = 'red';
    } else if (!regex.test(nombre)) {
        errors.push('El nombre debe contener solo letras y espacios.');
        nombreInput.style.borderColor = 'red';
    } else if (nombre.length > 30) {
        errors.push('El nombre no puede exceder los 30 caracteres.');
        nombreInput.style.borderColor = 'red';
    } else {
        nombreInput.style.borderColor = ''; // Restablecer el borde a su color normal
    }

    const usuarioInput = document.getElementById('autoSizingInputprecio');
    let usuario = usuarioInput.value.trim();

    if (usuario === '') {
        errors.push('El campo de usuario no puede estar vacío.');
        usuarioInput.style.borderColor = 'red';
    } else if (!regex.test(usuario)) {
        errors.push('El usuario debe contener solo letras y espacios.');
        usuarioInput.style.borderColor = 'red';
    } else if (usuario.length > 30) {
        errors.push('El usuario no puede exceder los 30 caracteres.');
        usuarioInput.style.borderColor = 'red';
    } else {
        usuarioInput.style.borderColor = ''; // Restablecer el borde a su color normal
    }

    const contraInput = document.getElementById('autoSizingInputPassword');
    let contraseña = contraInput.value;

    if (contraseña === '') {
        errors.push('El campo de contraseña no puede estar vacío.');
        contraInput.style.borderColor = 'red';
    } else {
        contraInput.style.borderColor = ''; // Restablecer el borde a su color normal
    }

    const contra2Input = document.getElementById('autoSizingInputConfirmPassword');
    let contraseña2 = contra2Input.value;

    if (contraseña2 === '') {
        errors.push('Debes confirmar la contraseña.');
        contra2Input.style.borderColor = 'red';
    } else if (contraseña !== contraseña2) {
        errors.push('Las contraseñas no coinciden.');
        contraInput.style.borderColor = 'red';
        contra2Input.style.borderColor = 'red';
    } else {
        contraInput.style.borderColor = ''; // Restablecer el borde a su color normal
        contra2Input.style.borderColor = ''; // Restablecer el borde a su color normal
    }

    const categoriaInput = document.getElementById('autoSizingSelectcat');
    let categoria = categoriaInput.value;
    if (categoria === 'Categoria') {
        errors.push('Debes seleccionar una categoría.');
        categoriaInput.style.borderColor = 'red';
    } else {
        categoriaInput.style.borderColor = ''; // Restablecer el borde a su color normal
    }

    // Mostrar todos los errores juntos si existen
    if (errors.length > 0) {
        alert(errors.join('\n'));
        return null; // Devolver null si hay errores
    }

    // Si no hay errores, devolver los datos del formulario
    return {
        nombre: nombre,
        usuario: usuario,
        contraseña: contraseña,
        contraseña2: contraseña2,
        categoria: categoria
    };
}


// Enviar el item al controlador para su posterior procesamiento
function enviarProducto(producto) {
    const searchTerm = document.querySelector('.form-control');
    const originalSearchTerm = searchTerm.value.trim().toLowerCase();

    fetch('http://localhost/Farmacia/src/controllers/ManejoUsuario.php?action=insertar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(producto)
    })
    .then(response => {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('notification'); // Añadir clase de notificación

        if (response.ok) {
            if (productosData.some(item => item.Usua === producto.usuario)) {
                messageContainer.textContent = 'El nombre de usuario ya existe, ingrese otro por favor';
                document.body.appendChild(messageContainer);
                setTimeout(() => messageContainer.remove(), 3000);  // Elimina la notificación después de 3 segundos
            } else {
                messageContainer.textContent = 'Nuevo usuario creado';
                document.body.appendChild(messageContainer);
                setTimeout(() => messageContainer.remove(), 3000);  // Elimina la notificación después de 3 segundos
                actualizarTabla();
            }
            
            // Vaciar la barra de búsqueda después de agregar un producto
            searchTerm.value = '';
        } else {
            response.json().then(error => {
                messageContainer.textContent = `Error: ${error.message}`;
                messageContainer.classList.add('error');  // Estilo para error
                document.body.appendChild(messageContainer);
                setTimeout(() => messageContainer.remove(), 3000);  // Elimina la notificación después de 3 segundos
            });
        }
    })
    .catch(handleError);
}


/// MODIFICARRRRR ///

function handleResponse(response) {
    const messageContainer = document.createElement('div');

    if (response.ok) {
        // Mensaje de éxito
        messageContainer.textContent = 'Usuario agregado correctamente.';
        setTimeout(() => messageContainer.remove(), 3000);  // Elimina el mensaje después de 3 segundos
        actualizarTabla();
    } else {
        // Mensaje de error
        response.json().then(error => {
            messageContainer.textContent = `Error: ${error.message}`;
            setTimeout(() => messageContainer.remove(), 3000);  // Elimina el mensaje después de 3 segundos
        });
    }

    // Añadir el contenedor de mensaje al body de la página
    document.body.appendChild(messageContainer);
}


//manejo de error
function handleError(error) {
    console.error('Error en la solicitud:', error);
}
//inicializa las pagina con sus respectivos registros de tabla por pagina
function initializePage() {
    const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
    obtenerProductos(1, itemsPerPage);
}
//envia a la pagina anterior
function goToPreviousPage() {
    const currentPage = parseInt(document.getElementById('currentPage').textContent);
    if (currentPage > 1) {
        const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
        obtenerProductos(currentPage - 1, itemsPerPage);
    }
}
//manda a la siguiente pagina de tabla
function goToNextPage() {
    const currentPage = parseInt(document.getElementById('currentPage').textContent);
    const totalPages = parseInt(document.getElementById('totalPages').textContent);
    if (currentPage < totalPages) {
        const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
        obtenerProductos(currentPage + 1, itemsPerPage);
    }
}
//maneja el cambio de items por pagina
function handleItemsPerPageChange() {
    obtenerProductos(1, parseInt(this.value));
}
//funcion para realizar la busqueda de items 
function handleSearchInput() {
    const searchTerm = this.value.trim().toLowerCase();
    if (searchTerm === '') {
        const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
        obtenerProductos(1, itemsPerPage);
    } else {
        fetch(`usuarios.php?search=${searchTerm}`)
            .then(response => response.json())
            .then(data => mostrarProductosFiltrados(data, searchTerm));
    }
}
//realiza el filtro en la tabla
function mostrarProductosFiltrados(data, searchTerm) {
    const productosFiltrados = data.filter(producto => producto.Nombre.toLowerCase().includes(searchTerm));
    const tabla = document.getElementById('contenidoTabla');
    tabla.innerHTML = productosFiltrados.length > 0 ? 
        productosFiltrados.map(producto => crearFilaProducto(producto)).join('') : 
        "<tr><td colspan='4'>No hay Usuarios disponibles</td></tr>";
    agregarEventosEdicionYEliminacion();  // Agregar los event listeners después de actualizar la tabla
}

//obtiene el producto del servidor
function obtenerProductos(page, itemsPerPage) {
    fetch(`usuarios.php?page=${page}&itemsPerPage=${itemsPerPage}`)
        .then(response => response.json())
        .then(data => {
            productosData = data; // Almacenar los datos en la variable global

            actualizarTablaProductos(data, page, itemsPerPage, 0)
            ocultarLoader();
        })
        .catch(error => console.error('Error al obtener los Usuarios:', error));
}
//oculta el loader de carga
function ocultarLoader() {
    document.getElementById('loader').style.display = 'block';
    
}
//actualiza la tabla despues de una insercion, eliminacion o edicion
function actualizarTablaProductos(data, page, itemsPerPage, centy) {
    const tabla = document.getElementById('contenidoTabla');
    tabla.innerHTML = data.length > 0 ? 
        data.slice((page - 1) * itemsPerPage, page * itemsPerPage).map(producto => crearFilaProducto(producto)).join('') : 
        "<tr><td colspan='4'>No hay Usuarios disponibles</td></tr>";

    document.getElementById('currentPage').textContent = page;
    document.getElementById('totalPages').textContent = Math.ceil(data.length / itemsPerPage);
    if (!filtroDataAdded) { // Verificar si el evento de filtrado ya se ha agregado
        agregarEventosFiltrado(data);
        filtroDataAdded = true; // Cambiar la bandera a true después de agregar el evento
    }
    
    agregarEventosEdicionYEliminacion();
}
// crea una fila del item en la tabla
function crearFilaProducto(producto) {
    const accionOcultar = producto.Estado == 1 ? "Ocultar" : "Mostrar";
    const claseOculto = producto.Estado == 0 ? "producto-oculto" : "";
    let tipo = "";
    if (producto.TipoUsuario_id == 1){
        producto.TipoUsuario_id = "Administrador";
    } else if (producto.TipoUsuario_id == 2){
        producto.TipoUsuario_id = "Stock";
    }  else if (producto.TipoUsuario_id == 3){
        producto.TipoUsuario_id = "Cocina";
    } 

    return `
    <tr class="${claseOculto}">
        <td class="nombre">${producto.Nombre}</td>
        <td>${producto.Usua}</td>
        <td>${producto.TipoUsuario_id}</td>
        <td class="centritoloco">
            <div class="dropdown">
                <div class="dropdown-content">
                    <!-- Icono de Editar -->
                    <a href="#" class="editarproducto" data-id="${producto.idUsuario}", nombre="${producto.Nombre}", usuario="${producto.Usua}", tipousuario="${producto.TipoUsuario_id}">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <!-- Icono de Eliminar -->
                    <a href="#" class="eliminar-producto" data-id="${producto.idUsuario}">
                        <i class="fas fa-trash"></i> Eliminar
                    </a>
                </div>
            </div>
        </td>
    </tr>
`;


}

