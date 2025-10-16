<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Inicio;
use BolsaTrabajo\Anuncio;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Condicion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Programa;
use BolsaTrabajo\Participantes;
use BolsaTrabajo\Alumno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InicioController extends Controller
{
        public function index(Request $request)
        {
            $fechaDesde = $request->input('fecha_desde', "2000-01-01");
            $fechaHasta = $request->input('fecha_hasta', Carbon::now()->addDay()->format('Y-m-d'));
        
            // Obtener datos filtrados por fechas
            $totalAsistentes = $this->getTotalDeAsistentes($fechaDesde, $fechaHasta);
            $totalCelulas = $this->getTotalCelulas($fechaDesde, $fechaHasta);
            $totalActividades = $this->getTotalActividades($fechaDesde, $fechaHasta);
        
            $TotalDeAsistentesporCelula = $this->getTotalDeAsistentesporCelula($fechaDesde, $fechaHasta);
            $seguimientoPorCelula = $this->getSeguimientoPorCelula($fechaDesde, $fechaHasta);
            $asistenciasPresente = $this->getTotalAsistenciaP($fechaDesde, $fechaHasta);
            $asistenciasAusente = $this->getTotalAsistenciaA($fechaDesde, $fechaHasta);
            
            // Obtener datos para el gráfico sin promedio
            $asistenciasPorPrograma = $this->getTotalAsistenciasPorPrograma($fechaDesde, $fechaHasta);
        
            // Pasar los datos a la vista 'auth.inicio.index'
            if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR ||
                Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_ADMINISTRADOR ||
                Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_LIDER
                ) {
                return view('auth.inicio.index', compact('totalAsistentes', 
                    'totalCelulas', 'totalActividades', 'TotalDeAsistentesporCelula', 'seguimientoPorCelula',
                    'asistenciasPresente', 'asistenciasAusente','asistenciasPorPrograma', 
                    'fechaDesde', 'fechaHasta'));
            }
        
            return redirect('/auth/error'); // Redirige a una página predeterminada si la condición no se cumple
        }
    

        /* Indicadores */
        private function getTotalDeAsistentes($fecha_desde, $fecha_hasta)
        {
            return DB::table('asistentes')
                ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
                ->where('estado', '1') 
                ->whereNull('deleted_at') // no contar con los eliminados
                ->count();
        }
    
        private function getTotalCelulas($fecha_desde, $fecha_hasta)
        {
            return DB::table('celulas')
                ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
                ->where('estado', '=', 1) // Filtrar por estado igual a 1
                ->whereNull('deleted_at') // no contar con los eliminados
                ->count();
        }
    
    
        private function getTotalActividades($fecha_desde, $fecha_hasta)
        {
            return DB::table('calendarios')
                ->where('estado', '=', 1) // Filtrar por estado igual a 1
                ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
                ->whereNull('deleted_at') // no contar con los eliminados
                ->count();
        }
    
        /* Fin Indicadores */
        
        // Métodos privados con filtro por fecha
        /* Primer Grafico */
        private function getTotalDeAsistentesporCelula($fecha_desde, $fecha_hasta)
        {
            return DB::table('asistentes as a')
            ->join('celulas as c', 'a.celula_id', '=', 'c.id')
            ->where('c.estado', '=', 1) // Filtrar por estado igual a 1
            ->whereBetween('a.created_at', [$fecha_desde, $fecha_hasta])
            ->whereNull('a.deleted_at')
            ->selectRaw('c.nombre as celula, COUNT(*) as cantidad_asistentes')
            ->groupBy('c.nombre')
            ->get();
        }
        /* Segundo Grafico */
        public function getSeguimientoPorCelula($fecha_desde, $fecha_hasta)
        {
            return DB::table('seguimiento as s')
                ->join('celulas as c', 's.celula_id', '=', 'c.id')
                ->where('c.estado', '=', 1) // Filtrar por estado igual a 1
                ->whereBetween('s.fecha_contacto', [$fecha_desde, $fecha_hasta])
                ->whereNull('c.deleted_at') // no contar con los eliminados
                ->selectRaw('c.nombre as celula, COUNT(*) as cantidad_seguimientos')
                ->groupBy('c.nombre')
                ->orderBy('cantidad_seguimientos', 'desc') // Ordenar de mayor a menor
                ->get();
        }
        

        /* Tercer Grafico */
        public function getTotalAsistenciaP($fecha_desde, $fecha_hasta)
        {
            $results = DB::table('asistentes as a')
            ->join('asistencias as s', 'a.id', '=', 's.asistente_id')
            ->whereBetween('s.fecha_registro', [$fecha_desde, $fecha_hasta])
            ->where('a.estado', '1') 
            ->whereNull('a.deleted_at') // no contar con los eliminados
            ->whereNull('s.deleted_at')
            ->where('s.estado', 'presente') // filtrar solo las asistencias con estado "presente"
            ->select('a.nombre as asistente', DB::raw('COUNT(*) as total_asistencias'))
            ->groupBy('a.nombre')
            ->limit(4) // Limitar solo a 4 resultados
            ->get();

            // Preparar los datos para Highcharts
            $series = [];
            foreach ($results as $dato) {
                $serie = [
                    'name' => $dato->asistente,
                    'y' => $dato->total_asistencias,
                ];
                $series[] = $serie;
            }

            // Retornar los datos en formato JSON
            return $series;
        }

        /* Cuarto Grafico */
        public function getTotalAsistenciaA($fecha_desde, $fecha_hasta)
        {
            $results = DB::table('asistentes as a')
            ->join('asistencias as s', 'a.id', '=', 's.asistente_id')
            ->whereBetween('s.fecha_registro', [$fecha_desde, $fecha_hasta])
            ->where('a.estado', '1') 
            ->whereNull('a.deleted_at') // no contar con los eliminados
            ->whereNull('s.deleted_at')
            ->where('s.estado', 'ausente') // filtrar solo las asistencias con estado "ausente"
            ->select('a.nombre as asistente', DB::raw('COUNT(*) as total_asistencias'))
            ->groupBy('a.nombre')
            ->limit(4) // Limitar solo a 4 resultados
            ->get();

            // Preparar los datos para Highcharts
            $series = [];
            foreach ($results as $dato) {
                $serie = [
                    'name' => $dato->asistente,
                    'y' => $dato->total_asistencias,
                ];
                $series[] = $serie;
            }

            // Retornar los datos en formato JSON
            return $series;
        }

        public function getTotalAsistenciasPorPrograma($fechaDesde, $fechaHasta)
        {
            // Obtener el conteo de asistentes por programa
            $conteosPorPrograma = DB::table('asistencias as a')
                ->join('tipo_programas as tp', 'a.programa_id', '=', 'tp.id')
                ->whereBetween('a.fecha_registro', [$fechaDesde, $fechaHasta])
                ->whereNull('a.deleted_at')
                ->where('a.estado', 'presente') // Filtrar solo asistentes presentes
                ->select('a.programa_id', 'tp.nombre as nombre_programa', DB::raw('COUNT(DISTINCT a.asistente_id) as total_asistentes'))
                ->groupBy('a.programa_id', 'tp.nombre')
                ->get();

            // Preparar los datos para Highcharts
            $series = [];
            foreach ($conteosPorPrograma as $dato) {
                $serie = [
                    'name' => $dato->nombre_programa,
                    'y' => $dato->total_asistentes,
                ];
                $series[] = $serie;
            }

            return $series;
        }

        public function listSeguimiento(Request $request)
        {
            // Llamar al procedimiento almacenado
            $data = DB::select('CALL ObtenerDatosSeguimiento()');
            // Retornar los datos en formato JSON
            return response()->json([
                'data' => $data
            ]);
        }


        


        


        
}