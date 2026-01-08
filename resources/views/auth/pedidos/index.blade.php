@extends('auth.index')

@section('titulo')
<title>Registrar Pedido</title>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('app/assets_pedidos/style.css') }}">
@endsection

@section('contenido')
<div class="content-wrapper">
    <section class="content-header d-flex justify-content-between align-items-center header-animado"
        style="padding: 15px 25px; border-bottom: 2px solid #e0e0e0; background: linear-gradient(to right, #5864ff, #646eff); border-radius: 8px;">
        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #fff; margin: 0; font-size: 1.8rem;">
            <i class="fa fa-shopping-cart" style="margin-right: 8px;"></i> Registrar Pedido
        </h1>
    </section>
    <div class="content">
        @if(session('success'))
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('auth.pedidos.store') }}" method="POST" id="form-pedido">
            @csrf

            {{-- DATOS DEL CLIENTE --}}
            <div class="form-section">
                <h5><i class="fa fa-user"></i> Datos del Cliente</h5>
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Usuario</label>
                        <select name="id_usuario" id="usuario_select" class="form-control" required>
                            <option value="{{ $userId }}" selected>{{ Auth::guard('web')->user()->nombres }}</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>N° Documento</label>
                        <div class="input-group">
                            <input id="num_doc" class="form-control" placeholder="Ingrese documento" maxlength="11">
                            <button type="button" id="btnBuscarCliente" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group col-lg-5">
                        <label>Razón Social / Nombre</label>
                        <input id="razonSocial" name="razon_social" class="form-control">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Dirección</label>
                        <input id="direccion" name="direccion" class="form-control">
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control"
                            placeholder="Ingrese teléfono" required>
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Fecha de pedido</label>
                        <input type="date" name="fecha_pedido" class="form-control" value="{{ date('Y-m-d') }}"
                            readonly>
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Fecha de entrega</label>
                        <input type="date" name="fecha_entrega" class="form-control" required>
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Método de pago</label>
                        <select name="metodo_pago" class="form-control" required>
                            <option value="" disabled selected>Seleccione método...</option>
                            @foreach($metodosPago as $metodo)
                            <option value="{{ $metodo->id_metodo_pago }}">{{ $metodo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Rerefencia</label>
                        <input type="text" name="referencia" id="telefono" class="form-control"
                            placeholder="Ingrese Referencia" required>
                    </div>

                </div>
            </div>

            <div class="form-section">
                <h5><i class="fa fa-truck"></i> Datos para el Envío</h5>
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Punto de llegada *</label>
                        <select name="punto_llegada" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <option value="almacen">Almacén Central</option>
                            <option value="tienda">Tienda Principal</option>
                            <option value="cliente">Dirección del Cliente</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Dirección *</label>
                        <input name="direccion_envio" class="form-control" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Ubigeo *</label>
                        <select name="ubigeo_envio" id="ubigeo_envio" class="form-control" required>
                            <option value="">Seleccione ubigeo...</option>
                            @foreach($ubigeos as $ubigeo)
                            <option value="{{ $ubigeo->id_ubigeo }}">
                                {{ $ubigeo->departamento }} - {{ $ubigeo->provincia }} - {{ $ubigeo->distrito }}
                            </option>
                            @endforeach
                        </select>

                    </div>


                </div>
            </div>

            <div class="form-section">
                <h5><i class="fa fa-box"></i> Productos</h5>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="form-group col-lg-12">
                            <input type="text" id="buscarProducto" class="form-control"
                                placeholder="Buscar producto...">
                        </div>
                        <div class="productos-pos" id="productosPos">
                            @foreach($productos as $producto)
                            <div class="producto-card" data-id="{{ $producto->id_producto }}"
                                data-nombre="{{ $producto->descripcion }}" data-precio="{{ $producto->precio_venta }}">

                                <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->descripcion }}">

                                <div class="info">
                                    <h6>{{ $producto->descripcion }}</h6>
                                    <p class="precio">S/ {{ number_format($producto->precio_venta, 2) }}</p>
                                    <p class="stock">Stock: {{ $producto->stock }}</p> {{-- mostramos stock --}}
                                </div>

                                <div class="acciones">
                                    <input type="number" class="cantidad" min="1" value="1">
                                    <button type="button" class="btn btn-add">Agregar</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-15">
                            <button type="button" class="btn btn-light-custom btn-sm" id="prevPage">Anterior</button>
                            <span id="pageInfo" class="mx-2"></span>
                            <button type="button" class="btn btn-light-custom btn-sm" id="nextPage">Siguiente</button>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <table class="table table-bordered" id="ticket-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="totals-ticket">
                            <p>Subtotal: S/ <span id="subtotal-ticket">0.00</span></p>
                            <p>IGV (18%): S/ <span id="igv-ticket">0.00</span></p>
                            <p><strong>Total: S/ <span id="total-ticket">0.00</span></strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-4">
                <button type="submit" class="btn btn-light-custom btn-lg" style="width: 100%;">
                    <i class="fa fa-save"></i> Registrar Pedido
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#ubigeo_envio').select2({
        placeholder: 'Buscar ubigeo...',
        allowClear: true,
        width: '100%'
    });
    function buscarCliente() {
        let documento = $('#num_doc').val().trim();
        if(documento === '') return;

        $.ajax({
            url: '/auth/clientes/search',
            method: 'GET',
            data: { documento: documento },
            success: function(res) {
                if(res && res.cliente) {
                    $('#razonSocial').val(res.cliente.nombres);
                    $('#direccion').val(res.cliente.direccion);
                    $('#telefono').val(res.cliente.telefono);
                    $('#email').val(res.cliente.email);
                } else {
                    alert('Cliente no encontrado');
                    $('#razonSocial, #direccion, #telefono, #email').val('');
                }
            },
            error: function() {
                alert('Error al buscar cliente');
            }
        });
    }

    // ✅ Botón de buscar
    $('#btnBuscarCliente').on('click', buscarCliente);

    // ✅ Enter en input de documento
    $('#num_doc').on('keypress', function(e) {
        if(e.which === 13) { // Enter
            e.preventDefault();
            buscarCliente();
        }
    });
});

</script>

<script type="text/javascript" src="{{ asset('auth/js/pedidos/index.js') }}"></script>

@endsection