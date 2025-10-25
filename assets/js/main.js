// Manejo de pedidos
document.addEventListener('DOMContentLoaded', function() {
    
    // Variables para el formulario de pedidos
    const btnAgregar = document.getElementById('btnAgregar');
    const formPedido = document.getElementById('formPedido');
    const listaProductos = document.getElementById('listaProductos');
    const totalPedido = document.getElementById('totalPedido');
    
    let productosCarrito = [];
    
    // Agregar producto al carrito
    if (btnAgregar) {
        btnAgregar.addEventListener('click', function() {
            const select = document.getElementById('producto_id');
            const cantidad = parseInt(document.getElementById('cantidad').value);
            
            if (!select.value) {
                alert('Por favor selecciona un producto');
                return;
            }
            
            if (cantidad <= 0) {
                alert('La cantidad debe ser mayor a 0');
                return;
            }
            
            const option = select.options[select.selectedIndex];
            const productoId = option.value;
            const nombre = option.getAttribute('data-nombre');
            const precio = parseFloat(option.getAttribute('data-precio'));
            const stock = parseInt(option.getAttribute('data-stock'));
            
            if (cantidad > stock) {
                alert('No hay suficiente stock. Stock disponible: ' + stock);
                return;
            }
            
            // Verificar si el producto ya está en el carrito
            const existe = productosCarrito.find(p => p.producto_id === productoId);
            if (existe) {
                alert('Este producto ya está en el pedido. Elimínalo si deseas cambiar la cantidad.');
                return;
            }
            
            const subtotal = precio * cantidad;
            
            productosCarrito.push({
                producto_id: productoId,
                nombre: nombre,
                precio: precio,
                cantidad: cantidad,
                subtotal: subtotal
            });
            
            actualizarTabla();
            
            // Limpiar selección
            select.value = '';
            document.getElementById('cantidad').value = 1;
        });
    }
    
    // Actualizar tabla de productos
    function actualizarTabla() {
        const emptyMessage = listaProductos.querySelector('.empty-message');
        if (emptyMessage) {
            emptyMessage.remove();
        }
        
        listaProductos.innerHTML = '';
        let total = 0;
        
        productosCarrito.forEach((producto, index) => {
            total += producto.subtotal;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${producto.nombre}</td>
                <td>S/. ${producto.precio.toFixed(2)}</td>
                <td>${producto.cantidad}</td>
                <td>S/. ${producto.subtotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-small btn-danger" onclick="eliminarProducto(${index})">
                        Eliminar
                    </button>
                </td>
            `;
            listaProductos.appendChild(row);
        });
        
        if (productosCarrito.length === 0) {
            listaProductos.innerHTML = `
                <tr class="empty-message">
                    <td colspan="5" style="text-align: center; color: #999;">
                        No hay productos agregados
                    </td>
                </tr>
            `;
        }
        
        totalPedido.textContent = total.toFixed(2);
    }
    
    // Función global para eliminar producto
    window.eliminarProducto = function(index) {
        if (confirm('¿Eliminar este producto del pedido?')) {
            productosCarrito.splice(index, 1);
            actualizarTabla();
        }
    }
    
    // Enviar formulario de pedido
    if (formPedido) {
        formPedido.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (productosCarrito.length === 0) {
                alert('Debes agregar al menos un producto al pedido');
                return;
            }
            
            const clienteId = document.getElementById('cliente_id').value;
            if (!clienteId) {
                alert('Por favor selecciona un cliente');
                return;
            }
            
            document.getElementById('detalles').value = JSON.stringify(productosCarrito);
            document.getElementById('total').value = totalPedido.textContent;
            
            formPedido.submit();
        });
    }
    
    // Ver detalle de pedido
    const modal = document.getElementById('modalDetalle');
    const span = document.getElementsByClassName('close')[0];
    const botonesDetalle = document.querySelectorAll('.ver-detalle');
    
    botonesDetalle.forEach(btn => {
        btn.addEventListener('click', function() {
            const pedidoId = this.getAttribute('data-id');
            
            fetch(`index.php?controller=pedido&action=detalle&id=${pedidoId}`)
                .then(response => response.json())
                .then(data => {
                    let html = '<table class="table"><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unit.</th><th>Subtotal</th></tr></thead><tbody>';
                    
                    data.forEach(item => {
                        html += `
                            <tr>
                                <td>${item.producto_nombre}</td>
                                <td>${item.cantidad}</td>
                                <td>S/. ${parseFloat(item.precio_unitario).toFixed(2)}</td>
                                <td>S/. ${parseFloat(item.subtotal).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    
                    html += '</tbody></table>';
                    document.getElementById('detalleContent').innerHTML = html;
                    modal.style.display = 'block';
                })
                .catch(error => {
                    alert('Error al cargar el detalle');
                    console.error(error);
                });
        });
    });
    
    if (span) {
        span.onclick = function() {
            modal.style.display = 'none';
        }
    }
    
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    
    // Actualizar estado de pedido
    const estadoSelects = document.querySelectorAll('.estado-select');
    estadoSelects.forEach(select => {
        select.addEventListener('change', function() {
            const pedidoId = this.getAttribute('data-id');
            const nuevoEstado = this.value;
            
            if (confirm('¿Cambiar el estado del pedido?')) {
                const formData = new FormData();
                formData.append('id', pedidoId);
                formData.append('estado', nuevoEstado);
                
                fetch('index.php?controller=pedido&action=actualizarEstado', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Estado actualizado correctamente');
                    } else {
                        alert('Error al actualizar el estado');
                    }
                })
                .catch(error => {
                    alert('Error de conexión');
                    console.error(error);
                });
            }
        });
    });
    
});

// Auto-ocultar alertas después de 5 segundos
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);