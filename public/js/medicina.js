document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchMedicamento");
    const btnAgregar = document.getElementById("btnAgregarMedicamento");
    const modal = document.getElementById("myModal");
    const formAgregarMedicamento = document.getElementById("formAgregarMedicamento");
    const tbody = document.getElementById("contenidoTabla");
    const btnCancelar = document.getElementById("btnformcancelarAdd"); // Botón Cancelar

    let currentMedicamentoId = null;

    // Abrir y cerrar el modal de agregar medicamento
    btnAgregar.addEventListener("click", () => {
        // Limpiar los valores del formulario y cambiar título
        document.getElementById("modalTitle").textContent = "Agregar Medicamento";
        formAgregarMedicamento.reset();
        currentMedicamentoId = null;  // Resetear el id para agregar
        modal.style.display = "block";
    });

    const closeModal = document.querySelector(".close");
    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Función para cerrar el modal (para el botón Cancelar)
    btnCancelar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Función para obtener los medicamentos de la base de datos
    function loadMedicamentos(search = "") {
        fetch(`../../src/controllers/get_medicamentos.php?search=${search}`)
            .then(response => response.json())
            .then(data => {
                tbody.innerHTML = "";
                data.forEach(medicamento => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${medicamento.id}</td>  <!-- Aquí se muestra 'id' como 'codigo' -->
                        <td>${medicamento.cantidad}</td>
                        <td>${medicamento.via_suministro}</td>
                        <td><button class="btn btn-primary" onclick="editarMedicamento(${medicamento.id})">Editar</button></td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error("Error al cargar los medicamentos:", error);
                alert("Hubo un problema al cargar los medicamentos.");
            });
    }

    loadMedicamentos();

    // Filtro de búsqueda
    searchInput.addEventListener("input", () => {
        loadMedicamentos(searchInput.value);
    });

    // Agregar o editar medicamento
    formAgregarMedicamento.addEventListener("submit", (e) => {
        e.preventDefault();

        const id = document.getElementById("nombreMedicamento").value; // Aquí agregamos 'id' manual
        const nombre = document.getElementById("nombreMedicamento").value;
        const cantidad = document.getElementById("cantidadMedicamento").value;
        const viaSuministro = document.getElementById("viaSuministroMedicamento").value;

        let url = "../../src/controllers/add_medicamento.php";
        let method = "POST";
        let data = { id, nombre, cantidad, via_suministro: viaSuministro };

        if (currentMedicamentoId !== null) {
            url = "../../src/controllers/editar_medicamento.php";
            method = "PUT";
            data.id = currentMedicamentoId;  // Añadir el id para actualizar
        }

        fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadMedicamentos();  // Recargar la lista después de agregar o editar
                modal.style.display = "none";
                formAgregarMedicamento.reset();
            } else {
                alert("Error al guardar medicamento.");
            }
        })
        .catch(error => {
            console.error("Error al guardar medicamento:", error);
            alert("Hubo un problema al guardar el medicamento.");
        });
    });

    // Función de editar medicamento
    window.editarMedicamento = function(id) {
        fetch(`../../src/controllers/editar_medicamento.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);  // Verifica lo que llega desde el servidor
                if (data.error) {
                    alert("Hubo un problema al obtener los datos del medicamento: " + data.error);
                } else {
                    const medicamento = data[0];
                    document.getElementById("nombreMedicamento").value = medicamento.nombre;
                    document.getElementById("cantidadMedicamento").value = medicamento.cantidad;
                    document.getElementById("viaSuministroMedicamento").value = medicamento.via_suministro;
                    currentMedicamentoId = id;  // Guardar el id del medicamento a editar
                    document.getElementById("modalTitle").textContent = "Editar Medicamento";
                    modal.style.display = "block";
                }
            })
            .catch(error => {
                console.error("Error al obtener medicamento:", error);
                alert("Hubo un problema al obtener los datos del medicamento.");
            });
    };
    
});
