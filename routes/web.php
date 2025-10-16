<?php

App::setLocale('es');

Route::get('/', 'App\HomeController@index')->name('index');
Route::get('/loginEmpresa', 'App\HomeController@loginEmpresa')->name('loginEmpresa');
Route::get('/filtro_distritos/{id}', 'App\HomeController@filtro_distritos')->name('filtro_distritos');
Route::get('/offline_alumno/{id}', 'App\LoginAlumnoController@offline');

Route::get('/buscar_reniec/{data}', 'App\LoginEmpresaController@consultar_reniec')->name('buscar_reniec');
Route::get('/buscar_sunat/{data}', 'App\LoginEmpresaController@consultar_sunat')->name('buscar_sunat');

/* ADMINISTRADOR */
Route::get('/home/notification', 'Auth\EmpresaController@notification')->name('auth.home.notification');

Route::group(['prefix' => 'auth', 'middleware' => 'auth:web'], function () {
    Route::get('/home', 'Auth\HomeController@index')->name('auth.index');

    Route::group(['prefix' => 'inicio'], function () {
        Route::get('/', 'Auth\InicioController@index')->name('auth.inicio');
    });


    // SECTION USUARIO
    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'Auth\UsuariosController@index')->name('auth.usuarios');
        Route::get('/list_all', 'Auth\UsuariosController@list_all')->name('auth.usuarios.list_all');
        Route::post('/store', 'Auth\UsuariosController@store')->name('auth.usuarios.store');
        Route::post('/delete', 'Auth\UsuariosController@delete')->name('auth.usuarios.delete');
        Route::get('/partialView/{id}', 'Auth\UsuariosController@partialView')->name('auth.usuarios.create');
    });

    // END SECTION USUARIO

    Route::group(['prefix' => 'cargo'], function () {
        Route::get('/', 'Auth\CargoController@index')->name('auth.cargo');
        Route::get('/list_all', 'Auth\CargoController@list_all')->name('auth.cargo.list_all');
        Route::get('/partialView/{id}', 'Auth\CargoController@partialView')->name('auth.cargo.create');
        Route::post('/store', 'Auth\CargoController@store')->name('auth.cargo.store');
        Route::post('/delete', 'Auth\CargoController@delete')->name('auth.cargo.delete');
    });


    Route::group(['prefix' => 'principal'], function () {
        Route::get('/', 'Auth\PrincipalController@index')->name('auth.principal');

    });

    Route::group(['prefix' => 'error'], function () {
        Route::get('/', 'Auth\ErrorController@index')->name('auth.error');

    });

    /* TOMA DE PEDIDOS */
    Route::group(['prefix' => 'pedidos'], function () {
        Route::get('', 'Auth\PedidosController@index')->name('auth.pedidos');
        Route::get('listado', 'Auth\PedidosController@verlistado')->name('auth.pedidos.listado');
        Route::get('gestion', 'Auth\PedidosController@gestiondepedidos')->name('auth.pedidos.gestion');
        Route::post('store', 'Auth\PedidosController@store')->name('auth.pedidos.store');
        Route::get('list_all', 'Auth\PedidosController@list_all')->name('auth.pedidos.list_all');
        Route::post('delete', 'Auth\PedidosController@delete')->name('auth.pedidos.delete');

        // NUEVAS RUTAS PARA SEGUIMIENTO 1:1
        Route::get('gestion/list', 'Auth\PedidosController@gestionList')->name('auth.pedidos.gestion_list');
        Route::get('gestion/get', 'Auth\PedidosController@gestionGet')->name('auth.pedidos.gestion_get');
        Route::post('gestion/update', 'Auth\PedidosController@gestionUpdate')->name('auth.pedidos.gestion_update');
    });

    /* GESTION DE producto */
    Route::group(['prefix' => 'productos'], function () {
        Route::get('', 'Auth\ProductosController@index')->name('auth.productos');
        Route::post('/store', 'Auth\ProductosController@store')->name('auth.productos.store');
        Route::get('/list_all', 'Auth\ProductosController@list_all')->name('auth.productos.list_all');
        Route::post('/delete', 'Auth\ProductosController@delete')->name('auth.productos.delete');
        Route::get('/partialView/{id}', 'Auth\ProductosController@partialView')->name('auth.productos.create');
    });

});

//Pagina principal
Route::post('/home/store', 'App\HomeController@store')->name('home.store');
Route::get('/registro', 'App\RegistroController@index')->name('app.registro.index');
Route::post('/registro/store', 'App\RegistroController@store')->name('registro.store');

Route::group(['prefix' => 'auth'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('login', 'Auth\LoginController@login')->name('auth.login.store'); // Ruta para el inicio de sesi��n
    Route::post('login', 'Auth\LoginController@login')->name('auth.login.post');
    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

    Route::get('/changePassword/partialView', 'Auth\LoginController@partialView_change_password')->name('auth.login.partialView_change_password');
    Route::post('/changePassword', 'Auth\LoginController@change_password')->name('auth.login.change_password');

    /*Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');*/
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');