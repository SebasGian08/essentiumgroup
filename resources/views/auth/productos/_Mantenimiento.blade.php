<style>
/* ===== Modal de Mantenimiento de Productos ===== */

#modalMantenimientoProductos .modal-content {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e9ecef;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    background-color: #fff;
    transition: all 0.3s ease-in-out;
}

/* Header */
#modalMantenimientoProductos .modal-header {
    background: linear-gradient(to right, #ffffffff, #ffffffff);
    color: #fff;
    border-bottom: none;
    padding: 1rem 1.5rem;
}

#modalMantenimientoProductos .modal-header .modal-title {
    color: #34495e;
    text-transform: none;
    font-size: 1.1rem;
}

#modalMantenimientoProductos .modal-header .btn-close {
    filter: invert(1);
    opacity: 0.8;
}

#modalMantenimientoProductos .modal-header .btn-close:hover {
    opacity: 1;
}

/* Body */
#modalMantenimientoProductos .modal-body {
    background-color: #f8f9ff;
    border-top: 1px solid #f0f1f5;
    border-bottom: 1px solid #f0f1f5;
}

#modalMantenimientoProductos label {
    font-size: 0.9rem;
    color: #000000ff;
    display: block;
    margin-bottom: 0.25rem;
    padding-left: 6px;
}

#modalMantenimientoProductos input.form-control,
#modalMantenimientoProductos select.form-select {
    border-radius: 8px;
    border: 1px solid #ced4da;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

#modalMantenimientoProductos input.form-control:focus,
#modalMantenimientoProductos select.form-select:focus {
    border-color: #5864ff;
    box-shadow: 0 0 0 0.15rem rgba(88, 100, 255, 0.25);
}

#modalMantenimientoProductos small.text-danger {
    font-size: 0.8rem;
}

/* Imagen */
#previewImagen {
    max-width: 150px;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 3px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

#previewImagen:hover {
    transform: scale(1.05);
}

/* Footer */
#modalMantenimientoProductos .modal-footer {
    background-color: #f8f9fb;
    border-top: 1px solid #e3e6ef;
}

#modalMantenimientoProductos .btn-outline-secondary {
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
}

#modalMantenimientoProductos .btn-primary {
    background-color: #5864ff;
    border-color: #5864ff;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s;
}

#modalMantenimientoProductos .btn-primary:hover {
    background-color: #4450e6;
    border-color: #4450e6;
    box-shadow: 0 2px 10px rgba(88, 100, 255, 0.3);
}

/* Responsividad */
@media (max-width: 768px) {
    #modalMantenimientoProductos .modal-dialog {
        margin: 0.5rem;
    }

    #modalMantenimientoProductos .modal-body {
        padding: 1rem;
    }
}
</style>
<div id="modalMantenimientoProductos" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="registroProductos" method="POST" action="{{ route('auth.productos.store') }}"
            enctype="multipart/form-data" data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroProductos" data-ajax-failure="OnFailureRegistroProductos">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $Producto != null ? 'Modificar' : 'Registrar' }} Producto</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body row">
                    @csrf
                    <input type="hidden" name="id_producto" id="id_producto"
                        value="{{ $Producto != null ? $Producto->id_producto : 0 }}">
                    <!-- Código del producto -->
                    <div class="form-group col-md-6">
                        <label for="codigo_producto"><b>Código Producto</b></label>
                        <input type="text" class="form-control" name="codigo_producto" id="codigo_producto"
                            value="{{ $Producto ? $Producto->codigo_producto : '' }}">
                        <span data-valmsg-for="codigo_producto" class="text-danger"></span>
                    </div>

                    <!-- Marca -->
                    <div class="form-group col-md-6">
                        <label for="id_producto_marca"><b>Marca</b></label>
                        <select class="form-control" name="id_producto_marca" id="id_producto_marca" required>
                            <option value="">Seleccione una marca</option>
                            @foreach($Marcas as $marca)
                            <option value="{{ $marca->id_producto_marca }}"
                                {{ $Producto && $Producto->id_producto_marca == $marca->id_producto_marca ? 'selected' : '' }}>
                                {{ $marca->descripcion }}
                            </option>
                            @endforeach
                        </select>
                        <span data-valmsg-for="id_producto_marca" class="text-danger"></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-input" name="descripcion" id="descripcion"
                            value="{{ $Producto ? $Producto->descripcion : '' }}" required>
                        <span data-valmsg-for="descripcion" class="text-danger"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="precio">Precio</label>
                        <input type="number" class="form-input" name="precio" id="precio"
                            value="{{ $Producto ? $Producto->precio : '' }}" step="0.01" required>
                        <span data-valmsg-for="precio" class="text-danger"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-input" name="stock" id="stock"
                            value="{{ $Producto ? $Producto->stock : '' }}" required>
                        <span data-valmsg-for="stock" class="text-danger"></span>
                    </div>

                    <!-- Imagen del producto -->
                    <div class="form-group col-md-6">
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-input" name="imagen" id="imagen" accept="image/*">
                        <span data-valmsg-for="imagen" class="text-danger"></span>

                        <div class="mt-2">
                            <img id="previewImagen"
                                src="{{ $Producto && $Producto->imagen ? asset($Producto->imagen) : '#' }}"
                                style="{{ $Producto && $Producto->imagen ? '' : 'display:none;' }} max-width: 150px; border-radius:5px;"
                                alt="Preview">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="estado">Estado</label>
                        <select class="form-input" name="estado" id="estado" required>
                            <option value="1" {{ $Producto && $Producto->estado == '1' ? 'selected' : '' }}>Activo
                            </option>
                            <option value="2" {{ $Producto && $Producto->estado == '2' ? 'selected' : '' }}>Inactivo
                            </option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-bold btn-pure btn-primary">
                        {{ $Producto != null ? 'Modificar' : 'Registrar' }} Producto
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Previsualización de imagen al seleccionar
document.getElementById('imagen').addEventListener('change', function(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('previewImagen');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
});
</script>
<script type="text/javascript" src="{{ asset('auth/js/productos/_Mantenimiento.js') }}"></script>