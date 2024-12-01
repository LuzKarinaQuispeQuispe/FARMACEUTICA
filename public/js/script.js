let filtroDataAdded = false; // Bandera para indicar si se ha agregado el evento de filtrado
let productosData; // Variable global para almacenar los datos
// Carga los eventos principales
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
