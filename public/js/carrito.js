let productosEnCarrito = JSON.parse(sessionStorage.getItem('carrito')) || [];

function agregarAlCarrito(codigo, tipo, cantidad, precio, imagen) {
    const cantidadInt = parseInt(cantidad);
    const productoExistente = productosEnCarrito.find(producto => producto.codigo === codigo);

    if (productoExistente) {
        productoExistente.cantidad += cantidadInt;
    } else {
        productosEnCarrito.push({ codigo, tipo, cantidad: cantidadInt, precio: parseFloat(precio), imagen });
    }

    actualizarCarrito();
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('carrito-count').innerText = productosEnCarrito.reduce((total, producto) => total + producto.cantidad, 0);
});

function mostrarProductosEnCarrito() {
    const productosDiv = document.getElementById('productos-en-carrito');
    const total = productosEnCarrito.reduce((total, producto) => total + producto.precio * producto.cantidad, 0);

    productosDiv.innerHTML = productosEnCarrito.length === 0 
        ? '<p>No hay productos en el carrito.</p>' 
        : productosEnCarrito.map((producto, index) => {
            const subtotal = producto.precio * producto.cantidad;
            return `
                <div class="producto-carrito" style="display: flex; align-items: center; margin-bottom: 10px;">
                    <img src="../public/${producto.imagen}" alt="${producto.tipo}" class="producto-imagen" style="width: 80px; height: 80px; margin-right: 10px;">
                    <div style="flex-grow: 1;">
                        <h3 style="font-size: 16px;">${producto.tipo}</h3>
                        <p style="margin: 2px 0;">Código: ${producto.codigo}</p>
                        <div style="display: flex; align-items: center;">
                            <button style="background-color: #007bff; color: white; border: none; padding: 5px 10px; cursor: pointer;" onclick="cambiarCantidad(${index}, 1)">+</button>
                            <p style="margin: 0 10px;">Cantidad: <span id="cantidad-${index}">${producto.cantidad}</span></p>
                            <button style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer;" onclick="cambiarCantidad(${index}, -1)">-</button>
                        </div>
                        <p style="margin: 2px 0;">Precio: $${producto.precio}</p>
                        <p style="margin: 2px 0;">Subtotal: $${subtotal.toFixed(2)}</p>
                    </div>
                    <button style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer;" onclick="eliminarProductoDelCarrito(${index})">Eliminar</button>
                </div>`;
        }).join('') + `<p style="font-size: 18px; font-weight: bold;">Total a pagar: $${total.toFixed(2)}</p>`;
}

function cambiarCantidad(index, cambio) {
    const producto = productosEnCarrito[index];
    producto.cantidad += cambio;

    if (producto.cantidad < 1) {
        producto.cantidad = 1; // Evitar que la cantidad sea menor que 1
    }

    actualizarCarrito();
}

function confirmarPedido() {
    if (productosEnCarrito.length === 0) {
        alert('El carrito está vacío.');
        return;
    }

    fetch('../controllers/ProductoController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ 
            productos: JSON.stringify(productosEnCarrito)
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la confirmación del pedido.');
        }
        return response.text();
    })
    .then(data => {
        alert(data); // Muestra el mensaje que viene del servidor
        productosEnCarrito = [];
        sessionStorage.setItem('carrito', JSON.stringify(productosEnCarrito));
        mostrarProductosEnCarrito();
        document.getElementById('carrito-count').innerText = productosEnCarrito.length;
    })
    .catch(error => console.error('Error:', error));
}

function eliminarProductoDelCarrito(index) {
    productosEnCarrito.splice(index, 1);
    actualizarCarrito();
}

function actualizarCarrito() {
    sessionStorage.setItem('carrito', JSON.stringify(productosEnCarrito));
    mostrarProductosEnCarrito();
    document.getElementById('carrito-count').innerText = productosEnCarrito.reduce((total, producto) => total + producto.cantidad, 0);
}

function abrirVentanaEmergenteDesdeCarrito() {
    document.getElementById('ventana-emergente').style.display = 'block';
    mostrarProductosEnCarrito();
}

function cerrarVentana() {
    document.getElementById('ventana-emergente').style.display = 'none';
}
