@extends('auth.index')

@section('titulo')
<title>Gestión detallada de Pedidos</title>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('app/assets_pedidos/style.css') }}">
<style>
#tableGestionPedidos thead th {
    background-color: #272727;
    color: #fff;
    font-weight: 600;
    text-align: left;
    padding: 12px;
    border-radius: 8px 8px 0 0;
}
</style>
@endsection

@section('contenido')
<div class="content-wrapper">
    <section class="content-header d-flex justify-content-between align-items-center header-animado"
        style="padding: 15px 25px; border-bottom: 2px solid #e0e0e0; background: linear-gradient(to right, #5864ff, #646eff); border-radius: 8px;">
        <h1 style="color: #fff; margin: 0; font-size: 1.8rem;">
            <i class="fa fa-cogs mr-2"></i> Gestión de Pedidos
        </h1>
    </section>
    <br><br>
    <div class="form-section">
        <table id="tableGestionPedidos" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pedido</th>
                    <th>Usuario Asociado</th>
                    <th>Fecha Entrega</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modalGestionPedido" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <form id="formGestionSeguimiento" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        Gestionar Pedido</span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_pedido" id="g_id_pedido">
                    <input type="hidden" name="id_seguimiento" id="g_id_seguimiento">

                    <div class="row-content">
                        <!-- Panel Izquierdo -->
                        <div class="left-panel">
                            <div class="info-box">
                                <h6>Cliente</h6>
                                <div id="g_cliente"></div>
                            </div>

                            <div class="info-box">
                                <h6>Ubicación</h6>
                                <div id="g_ubigeo"></div>
                            </div>

                            <div class="info-box">
                                <h6>Motorizado</h6>
                                <input type="text" name="motorizado" id="g_motorizado" class="form-control"
                                    placeholder="Nombre del motorizado">
                            </div>

                            <div class="info-box">
                                <h6>Total</h6>
                                <div id="g_total" class="font-weight-bold text-primary"></div>
                            </div>
                        </div>

                        <!-- Panel Derecho -->
                        <div class="right-panel">
                            <div class="info-box">
                                <h6>Resumen del pedido</h6>
                                <div id="g_resumen"></div>
                            </div>

                            <h6>Detalle de productos</h6>
                            <div id="g_detalle" class="mb-3"></div>

                            <h6>Seguimiento (puedes marcar varios estados)</h6>
                            <div id="g_estados" class="mb-3">
                                <label><input type="checkbox" name="estado[]" value="pendiente" id="chk_pendiente">
                                    Pendiente</label>
                                <label><input type="checkbox" name="estado[]" value="confirmado" id="chk_confirmado">
                                    Confirmado</label>
                                <label><input type="checkbox" name="estado[]" value="validado" id="chk_validado">
                                    Validado</label>
                                <label><input type="checkbox" name="estado[]" value="por_preparar"
                                        id="chk_por_preparar"> Por preparar</label>
                                <label><input type="checkbox" name="estado[]" value="entregado" id="chk_entregado">
                                    Entregado</label>
                                <label><input type="checkbox" name="estado[]" value="anulado" id="chk_anulado">
                                    Anulado</label>
                            </div>

                            <div class="form-group">
                                <label>Comentario</label>
                                <textarea class="form-control" name="comentario" id="g_comentario" rows="2"></textarea>
                            </div>

                            <!-- <div class="form-group">
                                <label>Subir evidencias (puedes seleccionar varios)</label>
                                <input type="file" name="evidencias[]" id="g_evidencias" multiple
                                    class="form-control mb-2">
                                <div id="g_lista_evidencias"></div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnGuardarGestion" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDetallePedido" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modalGestionPedido" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <!-- === CABECERA === -->
            <div class="modal-header">
                <h5 class="modal-title">
                    Detalle del Pedido</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

<<<<<<< HEAD
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Cliente:</strong> <span id="d_cliente"></span></p>
                        <p><strong>Teléfono:</strong> <span id="d_telefono"></span></p>
                        <p><strong>Ubicación:</strong> <span id="d_ubicacion"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Motorizado:</strong> <span id="d_motorizado"></span></p>
                        <p><strong>Total:</strong> <span id="d_total"></span></p>
                        <p><strong>Resumen:</strong> <span id="d_resumen"></span></p>
                    </div>
                </div>

                <hr>

                <h6>Detalle de productos</h6>
                <div id="d_detalles"></div>

                <hr>

                <h6>Seguimiento</h6>
                <p id="d_comentario"></p>
            </div>

=======
            <!-- === CUERPO === -->
            <div class="modal-body">
                <!-- LOADER -->
                <div id="d_loading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando información del pedido...</p>
                </div>

                <!-- CONTENIDO -->
                <div id="d_contenido" class="d-none">
                    <div class="row-content">
                        <!-- PANEL USUARIO ASOCIADO -->
                        <div class="left-panel">
                            <div class="info-box">
                                <h6>Información del Usuario</h6>
                                <div><strong>Ecommerce:</strong> <span id="d_ecommerce_nombre"></span></div>
                                <div><strong>Nombres:</strong> <span id="d_usuario_nombre"></span></div>
                                <div><strong>Email:</strong> <span id="d_usuario_email"></span></div>
                                <div><strong>Telefono:</strong> <span id="d_telefono"></span></div>
                                <div><strong>Dirección:</strong> <span id="d_direccion_cliente"></span></div>

                            </div>
                        </div>
                        <!-- PANEL IZQUIERDO -->
                        <div class="left-panel">
                            <div class="info-box">
                                <h6>Información del Cliente</h6>
                                <div><strong>Cliente:</strong> <span id="d_cliente"></span></div>
                                <div><strong>Teléfono:</strong> <span id="d_telefono"></span></div>
                                <div><strong>Dirección:</strong> <span id="d_direccion_cliente"></span></div>
                            </div>
                        </div>

                        <!-- PANEL DERECHO -->
                        <div class="right-panel">
                            <div class="info-box">
                                <h6><i class="fas fa-receipt text-primary mr-1"></i> Información del Pedido</h6>
                                <div><strong>Pedido ID:</strong> <span id="d_pedido_id"></span></div>
                                <div><strong>Código Pedido:</strong> <span id="d_codigo_pedido"></span></div>
                                <div><strong>Método Pago:</strong> <span id="d_metodo_pago"></span></div>
                                <div><strong>Comentario:</strong> <span id="d_comentario"></span></div>
                                <div><strong>Tipo Entrega:</strong> <span id="d_tipo_entrega"></span></div>
                                <div><strong>Dirección Entrega:</strong> <span id="d_direccion_entrega"></span></div>
                                <div><strong>Ubicación:</strong> <span id="d_ubicacion"></span></div>
                                <div><strong>Fecha Pedido:</strong> <span id="d_fecha_pedido"></span></div>
                                <div><strong>Fecha Entrega:</strong> <span id="d_fecha_entrega"></span></div>
                                <div><strong>Motorizado:</strong> <span id="d_motorizado"></span></div>
                                <div><strong>Total:</strong> <span id="d_total"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- === DETALLE DE PRODUCTOS === -->
                    <div class="info-box mt-3">
                        <h6><i class="fas fa-boxes text-primary mr-1"></i> Detalle de Productos</h6>
                        <div id="g_detalle">
                            <div id="d_detalles" class="table-responsive"></div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- === PIE === -->
>>>>>>> 4f6f996 (gestion , productos)
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>



<<<<<<< HEAD
=======

>>>>>>> 4f6f996 (gestion , productos)
@endsection

@section('scripts')
<script src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
    const table = $('#tableGestionPedidos').DataTable({
        processing: true,
        ajax: {
            url: "{{ route('auth.pedidos.gestion_list') }}",
            dataSrc: 'data'
        },
        columns: [{
                data: null,
                render: (d, t, r, meta) => meta.row + 1
            },
            {
                data: 'codigo_pedido',
                render: (data) => `
                    <span style="
                        display: inline-block;
                        border-bottom: 2px solid #08bbff;
                        font-weight: 600;
                        color: #08bbff;
                        padding-bottom: 2px;
                    ">
                        <i class="fa fa-receipt me-1"></i> ${data}
                    </span>
                `
            },
            {
                data: 'nombre_usuario'
            },
            {
                data: 'fecha_pedido'
            },
            {
                data: 'total',
                render: d => `S/ ${parseFloat(d||0).toFixed(2)}`
            },
            {
                data: null,
                orderable: false,
                render: (d) => `
                    <button class="btn-gestionar" onclick="abrirGestion(${d.id_pedido})">
                        <i class="fa fa-cogs"></i> Gestionar
                    </button>
                    <button class="btn-gestionar" onclick="verDetalle(${d.id_pedido})" style="
                        background: linear-gradient(90deg, #191919, #272727);
                        color: #fff;
                        border: none;
                        padding: 6px 14px;
                        border-radius: 25px;
                        font-weight: 600;
                        font-size: 0.9rem;
                        margin-left: 5px;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                        transition: all 0.3s ease;
                    ">
                        <i class="fa fa-eye"></i> Ver detalle
                    </button>
                `
            }


        ],
        order: [
            [5, 'desc']
        ]
    });

    $('#btnGuardarGestion').click(saveGestion);
});

function actualizarEstados(estados) {
    for (const key in estados) {
        const checkbox = document.getElementById('chk_' + key);
        if (checkbox) checkbox.checked = estados[key] == 1;
    }
}

function abrirGestion(id_pedido) {
    $('#modalGestionPedido').modal('show');
    clearModal();

    $.ajax({
        url: "{{ route('auth.pedidos.gestion_get') }}",
        method: "GET",
        data: {
            id_pedido
        },
        success: function(resp) {
            if (!resp.success) {
                Swal.fire('Atención', 'No se pudo cargar el pedido', 'warning');
                return;
            }

            const p = resp.data;
            $('#g_id_pedido').val(p.id_pedido);
            $('#g_cliente').html(`<strong>${p.cliente}</strong><br/>${p.telefono||''}`);
            $('#g_ubigeo').text(`${p.departamento||''} - ${p.provincia||''} - ${p.distrito||''}`);
            $('#g_motorizado').val(p.motorizado || '');
            $('#g_resumen').html(`Pedido: ${p.fecha_pedido??''} <br> Entrega: ${p.fecha_entrega??''}`);
            $('#g_total').html(`S/ ${parseFloat(p.total||0).toFixed(2)}`);

            let htmlDet =
                '<table class="table table-sm"><thead><tr><th>Prod</th><th>Cant</th><th>Precio</th></tr></thead><tbody>';
            if (p.detalles?.length) {
                p.detalles.forEach(it => htmlDet +=
                    `<tr><td>${it.descripcion}</td><td>${it.cantidad}</td><td>S/ ${parseFloat(it.precio_unitario||0).toFixed(2)}</td></tr>`
                );
            } else htmlDet += '<tr><td colspan="3" class="text-muted">Sin detalles</td></tr>';
            htmlDet += '</tbody></table>';
            $('#g_detalle').html(htmlDet);

            if (p.seguimiento) {
                $('#g_id_seguimiento').val(p.seguimiento.id_seguimiento);
                actualizarEstados({
                    pendiente: p.seguimiento.pendiente || 0,
                    confirmado: p.seguimiento.confirmado || 0,
                    validado: p.seguimiento.validado || 0,
                    por_preparar: p.seguimiento.por_preparar || 0,
                    entregado: p.seguimiento.entregado || 0,
                    anulado: p.seguimiento.anulado || 0
                });
                $('#g_comentario').val(p.seguimiento.comentario || '');
                $('#g_motorizado').val(p.seguimiento.motorizado || '');

                let evidenciasHtml = '';
                const evKeys = ['evidencia_chat', 'evidencia_llamada', 'evidencia_llamada_chat',
                    'evidencia_entrega', 'evidencia_soporte'
                ];
                evKeys.forEach(k => {
                    if (p.seguimiento[k]) evidenciasHtml +=
                        `<div>${k}: <a href="${p.seguimiento[k]}" target="_blank">ver</a></div>`;
                });
                $('#g_lista_evidencias').html(evidenciasHtml);
            } else {
                $('#g_id_seguimiento').val('');
                $('input[name="estado[]"]').prop('checked', false);
            }
        },
        error: function() {
            Swal.fire('Error', 'Error al recuperar los datos del pedido', 'error');
        }
    });
}

function verDetalle(id_pedido) {
    $('#modalDetallePedido').modal('show');
    limpiarModalDetalle();

    $.ajax({
        url: "{{ route('auth.pedidos.gestion_get') }}",
        method: "GET",
        data: { id_pedido },
        beforeSend: function() {
            $('#d_loading').removeClass('d-none');
            $('#d_contenido').addClass('d-none');
        },
        success: function(resp) {
            $('#d_loading').addClass('d-none');
            $('#d_contenido').removeClass('d-none');

            if (!resp.success) {
                Swal.fire('Atención', 'No se pudo cargar el pedido', 'warning');
                return;
            }

            const p = resp.data;

<<<<<<< HEAD
            // Llenar datos generales
            $('#d_cliente').text(p.cliente || '-');
            $('#d_telefono').text(p.telefono || '-');
            $('#d_ubicacion').text(`${p.departamento || '-'} / ${p.provincia || '-'} / ${p.distrito || '-'}`);
            $('#d_motorizado').text(p.motorizado || '-');
            $('#d_total').text(`S/ ${parseFloat(p.total || 0).toFixed(2)}`);
            $('#d_resumen').html(`Pedido: ${p.fecha_pedido || '-'}<br>Entrega: ${p.fecha_entrega || '-'}`);
            $('#d_comentario').text(p.seguimiento?.comentario || '-');

            // Tabla de detalles
            let htmlDet = `
                <table class="table table-sm">
                    <thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr></thead>
=======
            // === Información del Usuario Asociado ===
            $('#d_ecommerce_nombre').text(p.ecommerce || '-');
            $('#d_usuario_nombre').text(p.nombre_usuario || '-');
            $('#d_usuario_email').text(p.email_usuario || '-');
            $('#d_telefono').text(p.telefono_usuario || '-');
            $('#d_direccion_cliente').text(p.direccion_usuario || '-');
            $('#d_metodo_pago').text(p.metodo_pago || '-');

            // === Información del Cliente ===
            $('#d_cliente').text(p.nombre_cliente || '-');
            $('#d_telefono').text(p.telefono_cliente || '-');
            $('#d_direccion_cliente').text(p.direccion_cliente || '-');

            // === Información del Pedido ===
            $('#d_pedido_id').text(p.id_pedido || '-');
            $('#d_codigo_pedido').text(p.codigo_pedido || '-');
            $('#d_metodo_pago').text(p.metodo_pago || '-');
            $('#d_comentario').text(p.observacion || '-');
            $('#d_tipo_entrega').text(p.tipo_pedido || '-');
            $('#d_direccion_entrega').text(p.direccion_envio || '-');
            $('#d_ubicacion').text(`${p.departamento || '-'} / ${p.provincia || '-'} / ${p.distrito || '-'}`);
            $('#d_fecha_pedido').text(p.fecha_pedido || '-');
            $('#d_fecha_entrega').text(p.fecha_entrega || '-');
            $('#d_motorizado').text(p.seguimiento?.motorizado || '-');
            $('#d_total').text(`S/ ${parseFloat(p.total || 0).toFixed(2)}`);

            // === Detalle de productos ===
            let htmlDet = `
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
>>>>>>> 4f6f996 (gestion , productos)
                    <tbody>
            `;
            if (p.detalles?.length) {
                p.detalles.forEach(it => {
<<<<<<< HEAD
                    htmlDet += `<tr>
                        <td>${it.descripcion}</td>
                        <td>${it.cantidad}</td>
                        <td>S/ ${parseFloat(it.precio_unitario || 0).toFixed(2)}</td>
                    </tr>`;
                });
            } else {
                htmlDet += `<tr><td colspan="3" class="text-muted">Sin detalles</td></tr>`;
            }
            htmlDet += '</tbody></table>';

            $('#d_detalles').html(htmlDet);
=======
                    const subtotal = parseFloat(it.cantidad * it.precio_unitario).toFixed(2);
                    htmlDet += `
                        <tr>
                            <td>${it.descripcion}</td>
                            <td>${it.cantidad}</td>
                            <td>S/ ${parseFloat(it.precio_unitario || 0).toFixed(2)}</td>
                            <td>S/ ${subtotal}</td>
                        </tr>
                    `;
                });
            } else {
                htmlDet += `<tr><td colspan="4" class="text-muted text-center">Sin detalles</td></tr>`;
            }
            htmlDet += '</tbody></table>';
            $('#d_detalles').html(htmlDet);

            // === Evidencias ===
            let evidenciasHtml = '';
            const evKeys = ['evidencia_chat', 'evidencia_llamada', 'evidencia_llamada_chat', 'evidencia_entrega', 'evidencia_soporte'];
            evKeys.forEach(k => {
                if (p.seguimiento && p.seguimiento[k]) {
                    evidenciasHtml += `
                        <div class="col-md-6 mb-2">
                            <strong>${k.replace('evidencia_', '').toUpperCase()}:</strong> 
                            <a href="${p.seguimiento[k]}" target="_blank" class="text-primary">Ver evidencia</a>
                        </div>
                    `;
                }
            });
            $('#d_evidencias').html(evidenciasHtml || '<p class="text-muted">Sin evidencias registradas</p>');
>>>>>>> 4f6f996 (gestion , productos)
        },

        error: function() {
            Swal.fire('Error', 'Error al recuperar los datos del pedido', 'error');
        }
    });
}

function limpiarModalDetalle() {
<<<<<<< HEAD
    $('#d_cliente, #d_telefono, #d_ubicacion, #d_motorizado, #d_total, #d_resumen, #d_comentario').text('');
    $('#d_detalles').html('<p class="text-muted">Cargando...</p>');
=======
    $('#d_cliente, #d_telefono, #d_direccion_cliente, #d_ubicacion, #d_fecha_pedido, #d_fecha_entrega, #d_metodo_pago, #d_total, #d_comentario, #d_usuario_nombre, #d_usuario_email, #d_tipo_entrega, #d_direccion_entrega, #d_pedido_id, #d_codigo_pedido, #d_motorizado')
        .text('');
    $('#d_detalles').html('');
    $('#d_evidencias').html('');
    $('#d_loading').removeClass('d-none');
    $('#d_contenido').addClass('d-none');
>>>>>>> 4f6f996 (gestion , productos)
}



function clearModal() {
    $('#g_id_pedido,#g_id_seguimiento').val('');
    $('#g_cliente,#g_detalle,#g_lista_evidencias,#g_resumen,#g_total,#g_ubigeo').empty();
    $('#g_comentario,#g_motorizado').val('');
    $('input[name="estado[]"]').prop('checked', false);
    $('#g_evidencias').val(null);
}

function saveGestion() {
    let form = document.getElementById('formGestionSeguimiento');
    let fd = new FormData(form);
    fd.append('id_pedido', $('#g_id_pedido').val());
    fd.append('id_seguimiento', $('#g_id_seguimiento').val() || '');
    fd.append('_token', '{{ csrf_token() }}');

    const estados = [];
    $('input[name="estado[]"]:checked').each(function() {
        estados.push($(this).val());
    });
    fd.delete('estado');
    estados.forEach(e => fd.append('estado[]', e));

    $.ajax({
        url: "{{ route('auth.pedidos.gestion_update') }}",
        method: "POST",
        processData: false,
        contentType: false,
        data: fd,
        success: function(resp) {
            if (resp.success) {
                Swal.fire('Éxito', 'Seguimiento guardado correctamente', 'success');
                $('#modalGestionPedido').modal('hide');
                $('#tableGestionPedidos').DataTable().ajax.reload(null, false);
            } else {
                Swal.fire('Atención', resp.message || 'Error al guardar', 'warning');
            }
        },
        error: function(err) {
            console.error(err);
            Swal.fire('Error', 'Error en el servidor al guardar seguimiento', 'error');
        }
    });
}
</script>
@endsection