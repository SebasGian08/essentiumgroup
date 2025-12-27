@extends('auth.index')

@section('titulo')
<title>Registro de Marcas</title>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('app/assets_pedidos/style.css') }}">
@endsection

@section('contenido')
<div class="content-wrapper">

    <section class="content-header d-flex justify-content-between align-items-center header-animado"
        style="padding: 15px 25px; border-bottom: 2px solid #e0e0e0; background: linear-gradient(to right, #5864ff, #646eff); border-radius: 8px;">
        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #fff; margin: 0; font-size: 1.8rem;">
            <i class="fa fa-tags mr-2" style="margin-right: 8px;"></i> Gestión de Marcas
        </h1>
        <ol class="breadcrumb" style="top: 15px !important;">
            <li class="breadcrumb-item">
                <button type="button" id="modalRegistrarMarca" class="btn-primary">
                    <i class="fa fa-plus"></i> Registrar Marca
                </button>
            </li>
        </ol>
    </section>

    <section class="content">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <br>
                <div class="form-section">
                    <table id="tableMarcas"
                        class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer">
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#tableMarcas').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('auth.marcas.list_all') }}",
        columns: [
            { title: 'ID', data: 'id_producto_marca', className: 'text-center' },
            { title: 'Descripción', data: 'descripcion' },
            { title: 'Estado', data: 'estado', className: 'text-center',
              render: function(data) {
                  return data == 1 ? '<span class="badge badge-success">Activo</span>' :
                                     '<span class="badge badge-danger">Inactivo</span>';
              }
            },
            { title: 'Acciones', data: 'id_producto_marca', className: 'text-center', orderable: false, searchable: false,
              render: function(id) {
                  return `
                    <a href="/auth/marcas/ver/${id}" class="btn btn-sm btn-outline-primary" title="Ver">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="/auth/marcas/editar/${id}" class="btn btn-sm btn-outline-warning" title="Editar">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger btn-eliminar-marca" data-id="${id}" title="Eliminar">
                        <i class="fa fa-trash"></i>
                    </button>
                  `;
              }
            }
        ],
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Botón eliminar
    $(document).on('click', '.btn-eliminar-marca', function() {
        let id = $(this).data('id');
        if(confirm('¿Desea eliminar esta marca?')) {
            $.ajax({
                url: "{{ route('auth.marcas.delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    alert(response.message);
                    $('#tableMarcas').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert('Ocurrió un error al eliminar la marca.');
                }
            });
        }
    });
});
</script>
@endsection
