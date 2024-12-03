document.addEventListener("DOMContentLoaded", () => {
    const productList = document.getElementById("product-list");

    // Mostrar el modal inicial
    const showInitialModal = () => {
        const modal = document.createElement("div");
        modal.className = "modal";
        modal.innerHTML = `
            <div class="modal-content">
                <h2>Buscar Venta</h2>
                <p>Ingresa el código de la venta:</p>
                <input type="text" id="codigo-venta" placeholder="Ejemplo: V1-003" />
                <button id="buscar-venta">Buscar</button>
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = "flex";

        document.getElementById("buscar-venta").addEventListener("click", () => {
            const codigo = document.getElementById("codigo-venta").value.trim();
            if (codigo) {
                fetchProducts(codigo);
                closeModal(modal);
            } else {
                alert("Por favor, ingresa un código válido.");
            }
        });
    };

    const fetchProducts = async (codigo) => {
        try {
            const response = await fetch(`api.php?action=getSaleDetailsByCode&codigo=${encodeURIComponent(codigo)}`);
            const products = await response.json();

            productList.innerHTML = ""; // Clear the list
            if (products.length === 0) {
                alert("No se encontraron productos para este código de venta.");
                return;
            }

            products.forEach(product => {
                const medicamentoData = JSON.parse(product.medicamento_info);
                const card = document.createElement("div");
                card.className = "product-card";
                card.innerHTML = `
                    <h2>${product.nombre_producto}</h2>
                    <button class="btn-view-more" 
                        data-nombre="${product.nombre_producto}" 
                        data-precio="${product.precio}" 
                        data-cantidad="${medicamentoData.cantidad}" 
                        data-via="${medicamentoData.via_suministro}" 
                        data-forma="${medicamentoData.forma}">
                        Ver más
                    </button>
                    <button class="btn-view-medicine" 
                        data-medicamento='${JSON.stringify(medicamentoData)}'>
                        Ver Medicamento
                    </button>
                `;
                productList.appendChild(card);
            });

            document.querySelectorAll(".btn-view-more").forEach(button => {
                button.addEventListener("click", (event) => {
                    const { nombre, precio, cantidad, via, forma } = event.target.dataset;
                    showModal(nombre, precio, cantidad, via, forma);
                });
            });

            document.querySelectorAll(".btn-view-medicine").forEach(button => {
                button.addEventListener("click", (event) => {
                    const medicamento = JSON.parse(event.target.dataset.medicamento);
                    showMedicineDetails(medicamento);
                });
            });
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    };

    const closeModal = (modal) => {
        document.body.removeChild(modal);
    };

    // Lógica para el modal inicial
    showInitialModal();
});

// Modal Logic for Product Details
const showModal = (nombre, precio, cantidad, via, forma) => {
    const modal = document.createElement("div");
    modal.className = "modal";
    modal.innerHTML = `
        <div class="modal-content">
            <h2>${nombre}</h2>
            <p><strong>Precio Unitario:</strong> $${precio}</p>
            <p><strong>Cantidad:</strong> ${cantidad}</p>
            <p><strong>Vía de Suministro:</strong> ${via}</p>
            <p><strong>Forma:</strong> ${forma}</p>
            <button class="modal-close" onclick="closeModal(this)">Cerrar</button>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = "flex";
};

const showMedicineDetails = (medicamento) => {
    const modal = document.createElement("div");
    modal.className = "modal";
    modal.innerHTML = `
        <div class="modal-content">
            <h2>Detalles del Medicamento</h2>
            ${Object.entries(medicamento)
                .filter(([key]) => key !== "cantidad" && key !== "via_suministro" && key !== "forma")
                .map(
                    ([key, value]) => `
                    <div class="medicine-detail">
                        <p class="title" onclick="toggleDetail(this)">+ ${key.toUpperCase()}</p>
                        <p class="content" style="display: none;">${value}</p>
                    </div>
                `
                )
                .join("")}
            <button class="modal-close" onclick="closeModal(this)">Cerrar</button>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = "flex";
};

const toggleDetail = (element) => {
    const content = element.nextElementSibling;
    content.style.display = content.style.display === "none" ? "block" : "none";
};

const closeModal = (btn) => {
    const modal = btn.parentElement.parentElement;
    document.body.removeChild(modal);
};
