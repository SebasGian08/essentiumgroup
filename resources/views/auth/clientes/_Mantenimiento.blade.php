<div id="modalMantenimientoClientes" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form enctype="multipart/form-data" action="{{ route('auth.clientes.store') }}" id="registroCliente" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroCliente" data-ajax-failure="OnFailureRegistroCliente">
            @csrf

            <input type="hidden" name="id_cliente"
                   value="{{ $Entity ? $Entity->id_cliente : 0 }}">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $Entity ? 'Modificar Cliente' : 'Registrar Cliente' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Documento</label>
                        <input type="text"
                               name="documento"
                               class="form-input"
                               value="{{ $Entity ? $Entity->documento : '' }}"
                               required>
                        <span data-valmsg-for="documento"></span>
                    </div>

                    <div class="form-group">
                        <label>Nombres completos</label>
                        <input type="text"
                               name="nombres"
                               class="form-input"
                               value="{{ $Entity ? $Entity->nombres : '' }}"
                               required>
                        <span data-valmsg-for="nombres"></span>
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text"
                               name="direccion"
                               class="form-input"
                               value="{{ $Entity ? $Entity->direccion : '' }}">
                    </div>

                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text"
                               name="telefono"
                               class="form-input"
                               value="{{ $Entity ? $Entity->telefono : '' }}">
                    </div>

                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email"
                               name="email"
                               class="form-input"
                               value="{{ $Entity ? $Entity->email : '' }}">
                    </div>

                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" class="form-input" required>
                            <option value="1"
                                {{ $Entity && $Entity->estado == 1 ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="0"
                                {{ $Entity && $Entity->estado == 0 ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ $Entity ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script src="{{ asset('auth/js/clientes/_Mantenimiento.js') }}"></script>

