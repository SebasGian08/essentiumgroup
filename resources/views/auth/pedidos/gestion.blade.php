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

<!-- Modal: Gestionar pedido -->
<style>
.btn-gestionar {
    background: linear-gradient(90deg, #5864ff, #00c3ff);
    border: none;
    color: #fff;
    padding: 6px 14px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.btn-gestionar i {
    margin-right: 6px;
    transition: transform 0.3s ease;
}

.btn-gestionar:hover {
    background: linear-gradient(90deg, #00c3ff, #5864ff);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.btn-gestionar:hover i {
    transform: rotate(20deg);
}

/* === MODAL GESTIÓN PEDIDO === */
#modalGestionPedido .modal-content {
    border-radius: 14px;
    border: none;
    overflow: hidden;
}

#modalGestionPedido .modal-header {
    /*     background: linear-gradient(90deg, #5864ff, #646eff); */
    color: #fff;
    border-bottom: none;
    padding: 1rem 1.5rem;
}


#modalGestionPedido .modal-body {
    background: #f8f9ff;
    padding: 1.5rem;
}

#modalGestionPedido h6 {
    color: #4a4a4a;
    margin-bottom: 0.3rem;
}

#modalGestionPedido .info-box {
    background: #fff;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    margin-bottom: 1rem;
}

#modalGestionPedido .info-box div {
    font-size: 0.9rem;
    color: #555;
}

#modalGestionPedido .row-content {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

#modalGestionPedido .left-panel,
#modalGestionPedido .right-panel {
    flex: 1;
    min-width: 300px;
}

#g_detalle {
    background: #fff;
    border-radius: 12px;
    padding: 0.8rem;
    max-height: 220px;
    overflow-y: auto;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
}

#modalGestionPedido #g_estados label {
    display: inline-block;
    background: #eef0ff;
    color: #333;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    margin: 3px;
    cursor: pointer;
    transition: all 0.2s ease;
}

#modalGestionPedido #g_estados input[type="checkbox"] {
    margin-right: 5px;
}

#modalGestionPedido #g_estados label:hover {
    background: #dce0ff;
}

#modalGestionPedido textarea,
#modalGestionPedido input[type="text"],
#modalGestionPedido input[type="file"] {
    border-radius: 10px;
}

#modalGestionPedido .modal-footer {
    border-top: none;
    background: #f8f9ff;
    padding: 1rem 1.5rem;
}

#modalGestionPedido .btn-primary {
    background: #5864ff;
    border: none;
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
}

#modalGestionPedido .btn-primary:hover {
    background: #4450e0;
}

@media (max-width: 768px) {
    #modalGestionPedido .row-content {
        flex-direction: column;
    }
}

.close {
    color: #000000ff !important;
}

</style>


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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header" style="background: #5864ff; color: #fff;">
                <h5 class="modal-title">Detalle del Pedido</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <!-- Contenido cargado dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


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
    $('#modalDetallePedido').modal('show'); // Modal solo lectura
    $('#modalDetallePedido .modal-body').html('<p>Cargando...</p>');

    $.ajax({
        url: "{{ route('auth.pedidos.gestion_get') }}",
        method: "GET",
        data: { id_pedido },
        success: function(resp) {
            if (!resp.success) {
                Swal.fire('Atención', 'No se pudo cargar el pedido', 'warning');
                return;
            }

            const p = resp.data;
            let html = `
                <h5>Cliente: ${p.cliente || '-'}</h5>
                <p>Teléfono: ${p.telefono || '-'}</p>
                <p>Ubicación: ${p.departamento || '-'} / ${p.provincia || '-'} / ${p.distrito || '-'}</p>
                <p>Motorizado: ${p.motorizado || '-'}</p>
                <p>Total: S/ ${parseFloat(p.total||0).toFixed(2)}</p>
                <h6>Resumen del pedido</h6>
                <p>Pedido: ${p.fecha_pedido || '-'} | Entrega: ${p.fecha_entrega || '-'}</p>
                <h6>Detalle de productos</h6>
                <table class="table table-sm">
                    <thead>
                        <tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>
                    </thead>
                    <tbody>
                        ${p.detalles?.map(it => `<tr><td>${it.descripcion}</td><td>${it.cantidad}</td><td>S/ ${parseFloat(it.precio_unitario||0).toFixed(2)}</td></tr>`).join('') || '<tr><td colspan="3" class="text-muted">Sin detalles</td></tr>'}
                    </tbody>
                </table>
                <h6>Seguimiento</h6>
                <p>${p.seguimiento?.comentario || '-'}</p>
            `;
            $('#modalDetallePedido .modal-body').html(html);
        },
        error: function() {
            Swal.fire('Error', 'Error al recuperar los datos del pedido', 'error');
        }
    });
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