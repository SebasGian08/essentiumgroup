@section('titulo')
<title>Registro Usuario</title>
@endsection

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="{{ asset('app/assets_registro_login/style.css') }}">

@section('content')
@endsection

<div class="container-form">
    <div class="form-information">
        <div class="form-information-childs">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ asset('app/img/logo2.png') }}" alt="Logo" class="logo" />
            </a>
            <h2>Crear una Cuenta</h2>
            <p class="sub-text">Completa tus datos para crear tu cuenta</p>
        </div>

        <form class="form form-register" action="{{ route('registro.store') }}" method="POST" novalidate>
            @csrf

            <div>
                <label>
                    <i class='bx bx-globe'></i>
                    <select name="pais" required>
                        <option value="" disabled selected>Selecciona tu país</option>
                        <option value="Perú">Perú</option>
                        <option value="Chile">Chile</option>
                        <option value="México">México</option>
                        <option value="Colombia">Colombia</option>
                    </select>
                </label>
            </div>

            <div>
                <label>
                    <i class='bx bx-store-alt'></i>
                    <input type="text" placeholder="Nombre Ecommerce" name="ecommerce" required>
                </label>
            </div>

            <div>
                <label>
                    <i class='bx bx-user'></i>
                    <input type="text" placeholder="Nombres y Apellidos" name="nombres" required>
                </label>
            </div>

            <div>
                <label>
                    <i class='bx bx-envelope'></i>
                    <input type="email" placeholder="Correo Electrónico" name="correo" required>
                </label>
            </div>

            <div>
                <label>
                    <i class='bx bx-user-circle'></i>
                    <input type="text" placeholder="Usuario" name="user" required>
                </label>
            </div>

            <div>
                <label>
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" placeholder="Contraseña" name="password" required>
                </label>
            </div>

            <div>
                <label>
                    <i class='bx bx-phone'></i>
                    <input type="text" placeholder="Teléfono" name="telefono" required>
                </label>
            </div>

            <input type="submit" value="Registrarse">

            <div class="alerta-error" style="display:none;">Todos los campos son obligatorios</div>
            <div class="alerta-exito" style="display:none;">Te registraste correctamente</div>
            <p class="text">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a></p>
            <p class="return-text">
                <a href="{{ route('index') }}" class="return-link">← Regresar a la página principal</a>
            </p>
            <!-- <div class="icons">
                <i class='bx bxl-facebook'></i>
                <i class='bx bxl-instagram'></i>
                <i class='bx bxl-tiktok'></i>
                <i class='bx bxl-linkedin'></i>
            </div>
            <p>Síguenos en nuestras redes sociales</p> -->
        </form>

    </div>
</div>
</div>


<script>
document.querySelector('.form-register').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: "POST",
            body: data,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const result = await response.json();

        if (response.ok && result.Success) {
            document.querySelector('.alerta-exito').style.display = 'block';
            document.querySelector('.alerta-error').style.display = 'none';
            form.reset();
        } else {
            console.error(result.Errors);
            document.querySelector('.alerta-error').style.display = 'block';
            document.querySelector('.alerta-exito').style.display = 'none';
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        document.querySelector('.alerta-error').style.display = 'block';
    }
});
</script>


<script src="{{ asset('app/assets_registro_login/js/script.js') }}"></script>