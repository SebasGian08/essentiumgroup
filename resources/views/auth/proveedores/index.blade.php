@extends('auth.index')

@section('titulo')
<title>Registro de Proveedores</title>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
<div class="content-wrapper">

    <section class="content-header d-flex justify-content-between align-items-center header-animado"
        style="padding: 15px 25px; border-bottom: 2px solid #e0e0e0; background: linear-gradient(to right, #5864ff, #646eff); border-radius: 8px;">
        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #fff; margin: 0; font-size: 1.8rem;">
            <i class="fa fa-truck mr-2"></i> Gestión de Proveedores
        </h1>
        <ol class="breadcrumb" style="top: 15px !important;">
            <li class="breadcrumb-item">
                <button type="button" class="btn-primary"><i class="fa fa-plus"></i> Registrar Proveedor</button>
            </li>
        </ol>
    </section>

    <section class="content">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <br>
                <div class="form-section">
                    <table id="tableProveedores"
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
<script type="text/javascript">
$(document).ready(function() {
    $('#tableProveedores').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('auth.proveedores.list_all') }}",
        columns: [
            { title: 'ID', data: 'id_proveedor', className: 'text-center' },
            { title: 'RUC', data: 'ruc' },
            { title: 'Razón Social', data: 'razon_social' },
            { title: 'Dirección', data: 'direccion' },
            { title: 'Teléfono', data: 'telefono' },
            { title: 'Email', data: 'email' },
            { title: 'Estado', data: 'estado', className: 'text-center',
              render: function(data) {
                  return data == 1 ? '<span class="badge badge-success">Activo</span>' :
                                     '<span class="badge badge-danger">Inactivo</span>';
              }
            },
            { title: 'Acciones', data: 'id_proveedor', className: 'text-center', orderable: false, searchable: false,
              render: function(id) {
                  return `
                    <button class="btn btn-sm btn-outline-danger btn-eliminar-proveedor" data-id="${id}" title="Eliminar">
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

    $(document).on('click', '.btn-eliminar-proveedor', function() {
        let id = $(this).data('id');
        if(confirm('¿Desea eliminar este proveedor?')) {
            $.ajax({
                url: "{{ route('auth.proveedores.delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    alert(response.message);
                    $('#tableProveedores').DataTable().ajax.reload();
                },
                error: function() {
                    alert('Ocurrió un error al eliminar el proveedor.');
                }
            });
        }
    });
});
</script>
@endsection
