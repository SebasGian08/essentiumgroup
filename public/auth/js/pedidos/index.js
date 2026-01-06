const productos = $(".producto-card");
let productosFiltrados = productos; // 👈 MUY IMPORTANTE
let paginaActual = 1;
const productosPorPagina = 8;

function initSelect2() {
    $('.producto-select').select2({
        placeholder: "Buscar producto...",
        allowClear: true,
        width: '100%'
    });
}
initSelect2();



function actualizarTotales() {
    let subtotal = 0;
    $("#ticket-table tbody tr").each(function () {
        const total = parseFloat($(this).find(".total-item").text()) || 0;
        subtotal += total;
    });
    const igv = subtotal * 0.18;
    const total = subtotal + igv;

    $("#subtotal-ticket").text(subtotal.toFixed(2));
    $("#igv-ticket").text(igv.toFixed(2));
    $("#total-ticket").text(total.toFixed(2));
}

$(document).on("click", ".btn-add", function () {
    const card = $(this).closest(".producto-card");
    const id = card.data("id");
    const nombre = card.data("nombre");
    const precio = parseFloat(card.attr("data-precio")) || 0;
    const cantidad = parseInt(card.find(".cantidad").val()) || 0;

    const filaExistente = $("#ticket-table tbody tr[data-id='" + id + "']");
    if (filaExistente.length > 0) {
        const nuevaCantidad = parseInt(filaExistente.find(".cant-item").text()) + cantidad;
        filaExistente.find(".cant-item").text(nuevaCantidad);
        filaExistente.find('.total-item').text((nuevaCantidad * precio).toFixed(2));

        // Actualizar input hidden solo de cantidad
        filaExistente.find('input[name$="[cantidad]"]').val(nuevaCantidad);
    }
    else {
        const index = $("#ticket-table tbody tr").length;
        const fila = `<tr data-id="${id}">
            <td>${nombre}
                <input type="hidden" name="productos[${index}][id_producto]" value="${id}">
                <input type="hidden" name="productos[${index}][cantidad]" value="${cantidad}">
                <input type="hidden" name="productos[${index}][precio]" value="${precio}">
            </td>
            <td class="cant-item">${cantidad}</td>
            <td>${precio.toFixed(2)}</td>
            <td class="total-item">${(cantidad * precio).toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-remove">X</button>
            </td>
        </tr>`;
        $("#ticket-table tbody").append(fila);
    }

    actualizarTotales();
});


function mostrarPagina(page) {
    productosFiltrados.hide();

    const start = (page - 1) * productosPorPagina;
    const end = start + productosPorPagina;

    productosFiltrados.slice(start, end).show();

    const totalPaginas = Math.ceil(productosFiltrados.length / productosPorPagina);
    $("#pageInfo").text(`Página ${page} de ${totalPaginas}`);
}


// Inicializar primera página
mostrarPagina(paginaActual);

// Botones de navegación
$("#prevPage").on("click", function () {
    if (paginaActual > 1) {
        paginaActual--;
        mostrarPagina(paginaActual);
    }
});

$("#nextPage").on("click", function () {
    const totalPaginas = Math.ceil(productosFiltrados.length / productosPorPagina);
    if (paginaActual < totalPaginas) {
        paginaActual++;
        mostrarPagina(paginaActual);
    }
});


// Buscador
$("#buscarProducto").on("keyup", function () {
    const busqueda = $(this).val().toLowerCase();

    productosFiltrados = $(".producto-card").filter(function () {
        return $(this).data("nombre").toLowerCase().includes(busqueda);
    });

    paginaActual = 1;
    mostrarPagina(paginaActual);
});


// Eliminar fila
$(document).on("click", ".btn-remove", function () {
    $(this).closest("tr").remove();
    actualizarTotales();
});