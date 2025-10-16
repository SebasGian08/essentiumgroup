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
                        <th>Fechas</th>
                        <!--  <th>Acciones</th> -->
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

    var table = $('#tablePedidos').DataTable({
        processing: true,
        serverSide: false, // 🔹 Cambia a true si luego usas Yajra DataTables
        responsive: true,
        paging: true,
        pageLength: 10,
        lengthChange: true,
        autoWidth: false,
        pagingType: 'simple_numbers',
        ajax: {
            url: "{{ route('auth.pedidos.list_all') }}",
            dataSrc: 'data',
            data: function(d) {
                d.fecha_inicio = $('#fecha_inicio').val();
                d.fecha_fin = $('#fecha_fin').val();
            }
        },
        columns: [{ // 🔹 Columna correlativo
                data: null,
                name: 'correlativo',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row +
                        1; // Para serverSide: meta.row + meta.settings._iDisplayStart + 1
                }
            },
            { // Fechas
                data: null,
                name: 'fechas',
                render: function(data, type, row) {
                    return `Entrega: ${row.fecha_entrega ?? ''}<br>Pedido: ${row.fecha_pedido ?? ''}`;
                }
            },
            /* { // Botón historial
                data: 'acciones',
                name: 'acciones',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                    <button class="btn-telegram" onclick="verHistorial(${row.id_pedido})">
                        <i class="fa fa-telegram"></i> Historial
                    </button>
                `;
                }
            }, */
            { // Comentario
                data: 'comentario',
                name: 'comentario',
                defaultContent: ''
            },
            { // Cliente + WhatsApp
                data: 'nombre_cliente',
                name: 'nombre_cliente',
                render: function(data, type, row) {
                    let telefono = row.telefono_cliente || '';
                    return `
                    <div class="cliente-column">
                        <div class="cliente-nombre">${data}</div>
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=${telefono}" class="cliente-whatsapp">
                            <i class="fa fa-whatsapp"></i> ${telefono}
                        </a>
                    </div>
                `;
                }
            },
            { // Productos
                data: 'productos',
                name: 'productos',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (!data || data.length === 0)
                        return '<span class="text-muted">Sin productos</span>';

                    let html = '<div class="productos-column">';
                    data.forEach(p => {
                        html +=
                            `<div class="producto-badge">${p.descripcion} (${p.cantidad})</div>`;
                    });
                    html += '</div>';
                    return html;
                }
            },
            { // Total
                data: 'total',
                name: 'total',
                render: function(data) {
                    return `<span class="total-badge">S/ ${parseFloat(data || 0).toFixed(2)}</span>`;
                }
            },
            { // Ubigeo
                data: null,
                name: 'ubigeo',
                render: function(data, type, row) {
                    const ubigeo =
                        `${row.departamento || ''} - ${row.provincia || ''} - ${row.distrito || ''}`;
                    return `
                    <div class="ubigeo-column">
                        <span class="ubigeo-text">${ubigeo}</span>
                    </div>
                `;
                }
            },
            { // Estado seguimiento
                data: 'estado_seguimiento',
                name: 'estado_seguimiento',
                render: function(data, type, row) {
                    if (!data || data.length === 0)
                        return '<span class="text-muted">Sin estado</span>';

                    let html = '';
                    data.forEach(function(estado) {
                        let icon = '';
                        let text = estado.charAt(0).toUpperCase() + estado.slice(1);

                        switch (estado) {
                            case 'pendiente':
                                icon = '<i class="fa fa-hourglass-start"></i>';
                                break;
                            case 'confirmado':
                                icon = '<i class="fa fa-phone"></i>';
                                break;
                            case 'validado':
                                icon = '<i class="fa fa-check-circle"></i>';
                                break;
                            case 'anulado':
                                icon = '<i class="fa fa-times-circle"></i>';
                                break;
                            case 'por_preparar':
                                icon = '<i class="fa fa-box"></i>';
                                break;
                            case 'entregado':
                                icon = '<i class="fa fa-truck"></i>';
                                break;
                            default:
                                icon = '<i class="fa fa-question-circle"></i>';
                        }

                        html +=
                            `<div class="estado-pedido ${estado}" style="margin-bottom:4px;">${icon} ${text}</div>`;
                    });

                    return html;
                }
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