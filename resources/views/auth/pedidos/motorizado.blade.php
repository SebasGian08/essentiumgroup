@extends('auth.index')

@section('titulo')
<title>Gestión de Pedidos - Motorizado</title>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('app/assets_pedidos/style.css') }}">
<style>
#tableMotorizado thead th {
    background-color: #272727;
    color: #fff;
    font-weight: 600;
}

.btn-gestionar {
    background: #5864ff;
    color: #fff;
    border: none;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: .85rem;
}

#modalGestionPedido .modal-content {
    border-radius: 12px;
    border: 1px solid #e9ecef;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .15);
    background-color: #fff;
}

#modalDetallePedido .modal-content {
    border-radius: 12px;
    border: 1px solid #e9ecef;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .15);
    background-color: #fff;
}
</style>
@endsection

@section('contenido')
<div class="content-wrapper">
    <section class="content-header" style="padding:15px; background:linear-gradient(90deg,#5864ff,#646eff); color:#fff">
        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #fff; margin: 0; font-size: 1.8rem;">
            <i class="fa fa-shopping-cart" style="margin-right: 8px;"></i> Pedidos de despacho
        </h1>
    </section>
    <br>
    <div class="form-section">
        <table id="tableMotorizado" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha Entrega</th>
                    <th>Dirección</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- Modal Gestión Motorizado --}}
<div class="modal fade" id="modalGestionPedido">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formGestionMotorizado">
                @csrf
                <input type="hidden" id="g_id_pedido">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Reprogramar Pedido</h5>
                    <button class="close text-black" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Fecha de Entrega</label>
                        <input type="date" id="g_fecha_entrega" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Dirección de Entrega</label>
                        <input type="text" id="g_direccion" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Comentario</label>
                        <textarea id="g_comentario" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="reprogramarPedido()">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detalle Pedido --}}
<div class="modal fade" id="modalDetallePedido">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Detalle del Pedido</h5>
                <button class="close text-black" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Pedido:</strong> <span id="d_codigo_pedido"></span></p>
                <p><strong>Fecha Entrega:</strong> <span id="d_fecha_entrega"></span></p>
                <p><strong>Total:</strong> <span id="d_total"></span></p>
                <h6>Productos</h6>
                <div id="d_detalles"></div>
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
    $('#tableMotorizado').DataTable({
        ajax: {
            url: "{{ route('auth.motorizado.list') }}",
            dataSrc: 'data'
        },
        columns: [{
                data: null,
                render: (d, t, r, m) => m.row + 1
            },
            {
                data: 'codigo_pedido'
            },
            {
                data: 'nombre_cliente'
            },
            {
                data: 'fecha_entrega'
            },
            {
                data: 'direccion_cliente'
            },
            {
                data: 'total',
                render: d => `S/ ${parseFloat(d).toFixed(2)}`
            },
            {
                data: null,
                render: d => `
                <button class="btn-gestionar" onclick="abrirGestion(${d.id_pedido})">Reprogramar</button>
                <a href="/auth/pedidos/${d.id_pedido}/guia" class="btn btn-dark btn-sm" target="_blank" style="border-radius: 25px;">Descargar Guía</a>
                <button class="btn btn-success btn-sm" style="border-radius:25px;" onclick="entregarPedido(${d.id_pedido})">Entregar</button>
            `
            }


        ]
    });
});

function abrirGestion(id) {
    $('#modalGestionPedido').modal('show');
    $.get("{{ route('auth.pedidos.gestion_get') }}", {
        id_pedido: id
    }, resp => {
        const p = resp.data;
        $('#g_id_pedido').val(p.id_pedido);
        $('#g_fecha_entrega').val(p.fecha_entrega);
        $('#g_direccion').val(p.direccion_cliente);
        $('#g_comentario').val(p.seguimiento?.comentario || '');
    });
}

function reprogramarPedido() {
    const idPedido = $('#g_id_pedido').val();
    const fechaEntrega = $('#g_fecha_entrega').val();
    const direccion = $('#g_direccion').val();
    const comentario = $('#g_comentario').val();

    if (!idPedido) return Swal.fire('Error', 'No se obtuvo el pedido', 'error');

    Swal.fire({
        title: 'Reprogramar Pedido?',
        icon: 'question',
        showCancelButton: true
    }).then(result => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: "{{ route('auth.pedidos.gestion_update') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id_pedido: idPedido,
                fecha_entrega: fechaEntrega,
                direccion: direccion,
                comentario: comentario,
                id_estado_seguimiento: 4 // 4 = REPROGRAMADO
            },
            success: function() {
                $('#tableMotorizado').DataTable().ajax.reload();
                $('#modalGestionPedido').modal('hide');
                Swal.fire('Reprogramado', 'El pedido ha sido actualizado', 'success');
            },
            error: function(xhr) {
                Swal.fire('Error', 'Ocurrió un error: ' + xhr.responseText, 'error');
            }
        });
    });
}

function verDetalle(id) {
    $('#modalDetallePedido').modal('show');
    $.get("{{ route('auth.pedidos.gestion_get') }}", {
        id_pedido: id
    }, resp => {
        const p = resp.data;
        $('#d_codigo_pedido').text(p.codigo_pedido);
        $('#d_fecha_entrega').text(p.fecha_entrega);
        $('#d_total').text(`S/ ${parseFloat(p.total).toFixed(2)}`);

        let html = '<table class="table table-bordered"><tr><th>Producto</th><th>Cantidad</th></tr>';
        p.detalles.forEach(i => {
            html += `<tr><td>${i.descripcion}</td><td>${i.cantidad}</td></tr>`;
        });
        html += '</table>';
        $('#d_detalles').html(html);
    });
}

function entregarPedido(idPedido) {
    Swal.fire({
        title: 'Confirmar entrega del pedido?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, entregar',
        cancelButtonText: 'Cancelar'
    }).then(result => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: "{{ route('auth.pedidos.entregar') }}", // ruta del controller
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id_pedido: idPedido
            },
            success: function(res) {
                $('#tableMotorizado').DataTable().ajax.reload();
                Swal.fire('Entregado', res.message, 'success');
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Ocurrió un error', 'error');
            }
        });
    });
}
</script>
@endsection