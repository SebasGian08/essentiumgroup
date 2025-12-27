@extends('auth.index')

@section('titulo')
<title>Listado de Compras</title>
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
            <i class="fa fa-shopping-cart" style="margin-right: 8px;"></i> Listado de Compras
        </h1>
    </section>

    <br>

    <div class="content">
        <!-- Filtros -->
        <div class="row mb-3 form-section">
            <div class="col-md-3">
                <input type="date" id="fecha_inicio" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" id="fecha_fin" class="form-control">
            </div>
            <div class="col-md-3">
                <button id="btn-filtrar" class="btn btn-light-custom">
                    <i class="fa fa-search"></i> Filtrar
                </button>
            </div>
        </div>

        <hr>

        <!-- Tabla -->
        <div class="form-section">
            <table id="tableCompras" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Documento</th>
                        <th>Número</th>
                        <th>Proveedor</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acción</th>
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

    let table = $('#tableCompras').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        paging: true,
        pageLength: 10,
        ajax: {
            url: "{{ route('auth.compras.list_all') }}",
            dataSrc: 'data',
            data: function(d) {
                d.fecha_inicio = $('#fecha_inicio').val();
                d.fecha_fin = $('#fecha_fin').val();
            }
        },
        columns: [{
                data: null,
                orderable: false,
                searchable: false,
                render: (data, type, row, meta) => meta.row + 1
            },
            {
                data: 'fecha_compra',
                render: data => data ?? ''
            },
            {
                data: 'tipo_documento',
                render: data => data.toUpperCase()
            },
            {
                data: 'numero_documento'
            },
            {
                data: 'razon_social'
            },
            {
                data: 'total',
                render: data => `<strong>S/ ${parseFloat(data || 0).toFixed(2)}</strong>`
            },
            {
                data: 'estado',
                render: function(estado) {
                    let texto = 'Anulado';
                    let badge = 'danger';

                    if (estado == 1) {
                        texto = 'Activo';
                        badge = 'primary';
                    }

                    return `<span class="badge badge-${badge}">${texto}</span>`;
                }
            },
            {
                data: 'id_compra',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(id) {
                    return `
                        <a href="/auth/compras/ver/${id}" 
                        class="btn btn-sm btn-outline-primary" 
                        title="Ver detalle de la compra">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="/auth/compras/editar/${id}" 
                        class="btn btn-sm btn-outline-warning" 
                        title="Editar compra">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger btn-eliminar-compra" 
                                data-id="${id}" 
                                title="Eliminar compra">
                            <i class="fa fa-trash"></i>
                        </button>
                    `;
                }
            }




        ],
        order: [
            [1, 'desc']
        ]
    });

    $('#btn-filtrar').click(function() {
        table.ajax.reload();
    });

});
</script>
@endsection