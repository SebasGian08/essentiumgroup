@extends('auth.index')

@section('titulo')
<title>Listado de Pedidos</title>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('app/assets_pedidos/style.css') }}">
<link rel="stylesheet" href="{{ asset('app/assets_pedidos/listado.css') }}">
@endsection

@section('contenido')

<div class="content-wrapper">
    <section class="content-header d-flex justify-content-between align-items-center header-animado"
        style="padding: 15px 25px; border-bottom: 2px solid #e0e0e0; background: linear-gradient(to right, #5864ff, #646eff); border-radius: 8px;">
        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #fff; margin: 0; font-size: 1.8rem;">
            <i class="fa fa-shopping-cart" style="margin-right: 8px;"></i> Listado de Pedidos
        </h1>
    </section>
    <br><br>
    <div class="content">
        <div class="row mb-3 form-section">
            <div class="col-md-3"><input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha Inicio">
            </div>
            <div class="col-md-3"><input type="date" id="fecha_fin" class="form-control" placeholder="Fecha Fin"></div>
            <div class="col-md-3">
                <select id="filtro_estado" class="form-control">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="validado">Validado</option>
                    <option value="entregado">Entregado</option>
                </select>

            </div>
            <div class="col-md-3">
                <button id="btn-filtrar" class="btn btn-light-custom btn-m"><i class="fa fa-search"></i>
                    Filtrar</button>
            </div>
        </div>
        <br><br>
        <hr>
        <div class="form-section">
            <table id="tablePedidos" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Fecha registro</th>
                        <th>Fecha entrega</th>
                        <th>Nota</th>
                        <th>Cliente</th>
                        <th>Producto(s)</th>
                        <th>Total</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
    const hoy = new Date().toISOString().split('T')[0];

    $('#fecha_inicio').val(hoy);
    $('#fecha_fin').val(hoy);

    var table = $('#tablePedidos').DataTable({
        processing: true,
        serverSide: false,
        scrollX: false,
        scrollCollapse: true,
        responsive: true,
        autoWidth: false,
        paging: true,
        pageLength: 10,
        lengthChange: true,
        pagingType: 'simple_numbers',
        ajax: {
            url: "{{ route('auth.pedidos.list_all') }}",
            dataSrc: 'data',
            data: function(d) {
                d.fecha_inicio = $('#fecha_inicio').val();
                d.fecha_fin = $('#fecha_fin').val();
                d.estado = $('#filtro_estado').val();
            }
        },
        columns: [{ // #
                data: null,
                orderable: false,
                searchable: false,
                width: "50px",
                render: (d, t, r, m) => m.row + 1
            },
            { // Código pedido
                data: 'codigo_pedido',
                name: 'codigo_pedido',
                width: "120px"
            },
            { // Fecha registro
                data: 'fecha_pedido',
                name: 'fecha_pedido',
                width: "120px",
                render: d => d ? d.split(' ')[0] : ''
            },
            { // Fecha entrega
                data: 'fecha_entrega',
                name: 'fecha_entrega',
                width: "120px"
            },
            { // Comentario
                data: 'comentario',
                width: "200px",
                defaultContent: ''
            },
            { // Cliente
                data: 'nombre_cliente',
                width: "240px",
                render: function(data, type, row) {
                    let telefono = row.telefono_cliente || '';
                    return `
                <div class="cliente-column">
                    <div class="cliente-nombre">${data}</div>
                    <a target="_blank"
                       href="https://api.whatsapp.com/send?phone=${telefono}"
                       class="cliente-whatsapp">
                        <i class="fa fa-whatsapp"></i> ${telefono}
                    </a>
                </div>`;
                }
            },
            { // Productos
                data: 'productos',
                orderable: false,
                searchable: false,
                width: "280px",
                render: function(data) {
                    if (!data || data.length === 0)
                        return '<span class="text-muted">Sin productos</span>';

                    return data.map(p =>
                        `<div class="producto-badge">${p.descripcion} (${p.cantidad})</div>`
                    ).join('');
                }
            },
            { // Total
                data: 'total',
                width: "110px",
                render: d => `<span class="total-badge">S/ ${parseFloat(d || 0).toFixed(2)}</span>`
            },
            { // Ubigeo
                data: null,
                width: "220px",
                render: r =>
                    `${r.departamento || ''} - ${r.provincia || ''} - ${r.distrito || ''}`
            },
            { // Estado
                data: 'estado_seguimiento',
                width: "130px",
                render: d => d ?
                    `<div class="estado-pedido">${d.replace('_', ' ')}</div>` :
                    '<span class="text-muted">Sin estado</span>'
            }
        ],
        order: [
            [1, 'desc']
        ],
        drawCallback: function() {
            this.api().columns.adjust();
            if (this.api().responsive) this.api().responsive.recalc();
        }
    });


    // Botón de filtro
    $('#btn-filtrar').click(function() {
        table.ajax.reload();
    });

});
</script>
@endsection