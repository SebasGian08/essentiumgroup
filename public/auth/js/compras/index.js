const productos = $(".producto-card");
let paginaActual = 1;
const productosPorPagina = 6;

// ===============================
// TOTALES
// ===============================
function actualizarTotales() {
    let subtotal = 0;

    $("#detalle-compra tbody tr").each(function () {
        const totalItem = parseFloat($(this).find(".total-item").text()) || 0;
        subtotal += totalItem;
    });

    const igv = subtotal * 0.18;
    const total = subtotal + igv;

    // Mostrar en pantalla
    $("#subtotal").text(subtotal.toFixed(2));
    $("#igv").text(igv.toFixed(2));
    $("#total").text(total.toFixed(2));

    // Enviar al backend (inputs hidden que YA agregaste)
    $("#input-subtotal").val(subtotal.toFixed(2));
    $("#input-igv").val(igv.toFixed(2));
    $("#input-total").val(total.toFixed(2));
}

// ===============================
// AGREGAR PRODUCTO
// ===============================
$(document).on("click", ".btn-add", function () {

    const card = $(this).closest(".producto-card");
    const id = card.data("id");
    const nombre = card.data("nombre");
    const cantidad = parseFloat(card.find(".cantidad").val());
    const costo = parseFloat(card.find(".costo").val());

    if (!cantidad || cantidad <= 0) {
        alert("Cantidad inválida");
        return;
    }

    if (!costo || costo <= 0) {
        alert("Ingrese costo válido");
        return;
    }

    const filaExistente = $("#detalle-compra tbody tr[data-id='" + id + "']");

    // ===============================
    // SI EL PRODUCTO YA EXISTE
    // ===============================
    if (filaExistente.length > 0) {

        const cantidadActual = parseFloat(filaExistente.find(".cant-item").text());
        const nuevaCantidad = cantidadActual + cantidad;
        const nuevoSubtotal = nuevaCantidad * costo;

        filaExistente.find(".cant-item").text(nuevaCantidad);
        filaExistente.find(".total-item").text(nuevoSubtotal.toFixed(2));

        // actualizar hidden inputs
        filaExistente.find('input[name$="[cantidad]"]').val(nuevaCantidad);
        filaExistente.find('input[name$="[costo]"]').val(costo);
        filaExistente.find('input[name$="[subtotal]"]').val(nuevoSubtotal.toFixed(2));

    } else {

        // ===============================
        // NUEVO PRODUCTO
        // ===============================
        const index = $("#detalle-compra tbody tr").length;
        const subtotalItem = cantidad * costo;

        const fila = `
        <tr data-id="${id}">
            <td>${nombre}
                <input type="hidden" name="detalle[${index}][id_producto]" value="${id}">
                <input type="hidden" name="detalle[${index}][cantidad]" value="${cantidad}">
                <input type="hidden" name="detalle[${index}][costo]" value="${costo}">
                <input type="hidden" name="detalle[${index}][subtotal]" value="${subtotalItem.toFixed(2)}">
            </td>
            <td class="cant-item">${cantidad}</td>
            <td>${costo.toFixed(2)}</td>
            <td class="total-item">${subtotalItem.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-remove">X</button>
            </td>
        </tr>`;

        $("#detalle-compra tbody").append(fila);
    }

    actualizarTotales();
});

// ===============================
// ELIMINAR ITEM
// ===============================
$(document).on("click", ".btn-remove", function () {
    $(this).closest("tr").remove();
    actualizarTotales();
});

// ===============================
// PAGINACIÓN
// ===============================
function mostrarPagina(page, listaProductos = null) {

    const lista = listaProductos || $(".producto-card");
    lista.hide();

    const start = (page - 1) * productosPorPagina;
    const end = start + productosPorPagina;
    lista.slice(start, end).show();

    const totalPaginas = Math.ceil(lista.length / productosPorPagina);
    $("#pageInfo").text(`Página ${page} de ${totalPaginas}`);
}

// Inicial
mostrarPagina(paginaActual);

// Botones
$("#prevPage").on("click", function () {
    if (paginaActual > 1) {
        paginaActual--;
        mostrarPagina(paginaActual, $(".producto-card:visible"));
    }
});

$("#nextPage").on("click", function () {
    const visibles = $(".producto-card:visible");
    const totalPaginas = Math.ceil(visibles.length / productosPorPagina);
    if (paginaActual < totalPaginas) {
        paginaActual++;
        mostrarPagina(paginaActual, visibles);
    }
});

// ===============================
// BUSCADOR
// ===============================
$("#buscarProducto").on("keyup", function () {
    const busqueda = $(this).val().toLowerCase();

    $(".producto-card").each(function () {
        const nombre = $(this).data("nombre").toLowerCase();
        $(this).toggle(nombre.includes(busqueda));
    });

    paginaActual = 1;
    mostrarPagina(paginaActual, $(".producto-card:visible"));
});
