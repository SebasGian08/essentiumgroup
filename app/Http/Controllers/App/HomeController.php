<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Alumno;
use BolsaTrabajo\App;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Actividad_economica;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Provincia;
use BolsaTrabajo\User;
use BolsaTrabajo\TipoPrograma;
use BolsaTrabajo\Celula;
use Carbon\Carbon;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    private $alumno, $empresa;

    public function __construct(Alumno $alumno, Empresa $empresa)
    {
        $this->middleware('guest:alumnos', ['except' => ['filtro_distritos']]);
        $this->middleware('guest:empresasw', ['except' => ['filtro_distritos']]);

        $this->alumno = $alumno;
        $this->empresa = $empresa;
    }

    public function filtro_distritos($id)
    {
        return response()->json(Distrito::where('provincia_id', $id)->orderBy('nombre', 'asc')->get());
    }

    public function actualizar()
    {
        $users = Alumno::where('id', '>=', 7970)->get();

        foreach ($users as $u){
            $alum = Alumno::find($u->id);
            $alum->password = Hash::make($u->password);
            $alum->save();
        }
    }
    
    public function index()
    {
        $tipoprograma = TipoPrograma::all();
        $celulas = Celula::where('estado', 1)->whereNull('deleted_at')->get();
        return view('app.home.index', compact('tipoprograma','celulas'));
    }

    

    public function loginEmpresa()
    {
        return view('app.home.empresa');
    }

    public function crear_empresa()
    {
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $Cargos = Cargo::all();
        $ActividadEconomica = Actividad_economica::all();

        return view('app.empresas.registrar', ['Areas' => $Areas, 'Provincias' => $Provincias, 'Cargos' => $Cargos, 'ActividadEconomica' => $ActividadEconomica]);
    }

    public function registrar_empresa(Request $request)
    {
        $status = false;

        $random = Str::upper(str_random(4)); $logo = null;

        if($request->file('logo') != null){
            $logo = uniqid($random . "_") . '.' . $request->file('logo')->getClientOriginalExtension();
        }

        $request->merge([
            'link' => Str::slug($request->nombre_comercial),
            'usuario_empresa' => $request->ruc,
            'password' => Hash::make($request->ruc),
            // 'logo' => $logo,
            'aprobado' => 0
        ]);

        $validator = Validator::make($request->all(), [
            // 'nombre_comercial' => 'required',
            'ruc' => 'required|unique:empresas',
            'link' => 'required|unique:empresas,link,'.($request->id != 0 ? $request->id : "NULL").',id,deleted_at,NULL',
            // 'razon_social' => 'required',
            // 'direccion' => 'required',
            // 'provincia_id' => 'required',
            // 'distrito_id' => 'required',
            // 'telefono' => 'required|digits:9',
            // 'email' => 'required|email',
            'usuario_empresa' => 'required',
            'password' => 'required',
            // 'descripcion' => 'required',
            // 'nombre_contacto' => 'required',
            // 'apellido_contacto' => 'required',
            // 'cargo_contacto' => 'required',
            // 'telefono_contacto' => 'required|digits:9',
            // 'email_contacto' => 'required|email'
        ]);

        if (!$validator->fails()){
            Empresa::create($request->all());

            if ($request->file('logo') != null)
                $request->file('logo')->move('uploads/empresas/logos', $logo);

            $status = true;
        }

        return $status ? redirect(route('loginEmpresa'))->with(['status' => '']) : redirect(route('empresa.crear_empresa'))->withErrors($validator)->withInput();
    }

    public function crear_alumno()
    {
        $Areas = Area::all();
        $Provincias = Provincia::all();
        /* $Anios = range(date('Y')-1, date('Y')-21); */


        return view('app.alumno.registrar', ['Areas' => $Areas, 'Provincias' => $Provincias]);
    }

    public function registrar_alumno(Request $request)
    {
        $status = false;

        $request->merge([
            'usuario_alumno' => $request->dni,
            'password' => Hash::make($request->dni),
            'aprobado' => $request->egresado != 0 ? 1 : 0,
            'fecha_nacimiento' => $request->fecha_nacimiento, 

        ]);
    
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'dni' => 'required|min:8|max:12|unique:alumnos',
             'email' => 'required|email',
             'fecha_nacimiento' => 'required|date|min:10',
             'provincia_id' => 'required',
             'distrito_id' => 'required',
           'area_id' => 'required',
            'usuario_alumno' => 'required',
            'password' => 'required'
        ]);

        if (!$validator->fails()){
            
            Alumno::create($request->all());

            $id = Alumno::latest('id')->first();        

            Alumno::where('id', $id->id )                      
            ->update(['aprobado' => 1]);

            $status = true;
        }

        return $status ? redirect(route('index'))->with(['status' => '']) : redirect(route('alumno.crear_alumno'))->withErrors($validator)->withInput();
    }

}