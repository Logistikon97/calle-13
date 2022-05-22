<?php

namespace App\Http\Controllers;

use App\Models\Datos;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Providers\Constantes;
use PhpParser\Node\Stmt\Foreach_;

/**
 * - Cuando se actualiza los datos, los comentarios se resetean.(ahora se conserva el dato al actualizar)
 * - Al buscar un listón, si no hay algún listón registrado, arroja error. (se corrigió código)
 * - Si no se ingresa un dato muestra una pantalla de error. (se puso required)
 */


class DatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$datos['elementos']=Datos::paginate(5);
        $datos['elementos'] = Datos::orderBy('fecha', 'desc')->paginate(10);
        return view('servicio.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicio.create');
    }
    /**
     * consulta informacón sobre el abonado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consultarAbonado(Request $request)
    {
        $datos = request()->all();
        $respuesta = Datos::where('abonado', $datos['abonado'])->orderBy('fecha', 'desc')->get();
        return view('servicio.consulta')->with('respuesta', $respuesta);
        //return response()->json($respuesta);
    }

    /**
     * consulta informacón sobre los puertos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consultarPuertos(Request $Resquest)
    {
        $datos = request()->all();
        !isset($datos['dslam']) ? $datos += ['dslam' => ''] : $datos['dslam'];


        $datos['pots'] != null && isset($datos['pots']) ? $pots = 'P:' . $datos['pots'] : $pots = '';
        $datos['adsl'] != null && isset($datos['adsl']) ? $adsl = 'A:' . $datos['adsl'] : $adsl = '';
        $datos['dslam'] != null ? $dslam = 'D:' . $datos['dslam'] : $dslam = '';
        $puertos = $pots . ' ' . $adsl . ' ' . $dslam;
        //return response()->json($datos);

        $resPuertos = Datos::where('puertos', 'LIKE', '%' . trim($puertos, " ") . '%')->orderBy('puertos', 'asc')->get();
        return view('servicio.consulta')->with('puertos', $resPuertos);
        //return response()->json($resPuertos);
    }

    /**
     * consulta informacón sobre los puertos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consultarPorListon(Request $Resquest)
    {
        $datos = request()->except('_token');
        $texto = trim($datos['liston']) . '-';
        if ($datos['liston'] == null) {
            echo 'no se puede porque hay espacios';
        } else {
            $respuesta = Datos::where('liston', 'LIKE', '%' . $texto . '%')->orderBy('liston', 'desc')->get();
            return view('servicio.listones')->with('liston', $respuesta);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Cuando ingresa un dato, primero verifica si existe en la base de datos
         * validando por los puertos. Si no hay duplicados entonces directamente lo inserta
         * pero si hay resultados en la consulta, entonces redirige a controlDuplicados
         * y desde allí se muestran los duplicados y confirma la inserción.
         */

        $datos = request()->except(['_token']); //recibe los datos menos el token

        /**
         * si hay duplicados desde controlDuplicados se envia una llave.
         * Entonces si existe no se deben formatear los datos.
         */
        if (!isset($datos['llave'])) {

            //formatea los datos para que coincida con la base de datos
            $puertos = 'P:' . $datos['pots'] . ' A:' . $datos['adsl'] . ' D:' . $datos['dslam'];
            $nombreTecnico = DatosController::tecnicos($datos['tecnico']);
            unset($datos['pots'], $datos['adsl'], $datos['dslam'], $datos['tecnico']);
            $datos += ['fecha' => Carbon::today()->format('Y-m-d'), 'puertos' => $puertos, 'tecnico' => $nombreTecnico, 'created_at' => Carbon::now('America/Bogota')];

            //consulta si hay duplicados
            $respuesta = Datos::where('puertos', $datos['puertos'])->get();

            //comprueba si hay resultados
            if (sizeof($respuesta) == 0) {
                DatosController::cambiarEstado();
                Datos::insert($datos); //si no hay resultados entonces guarda en BD
                return redirect('servicio');
            } else {
                //si hay resultados entonces muestra la información
                return view('servicio.controlDuplicados')->with('datosDuplicados', $respuesta)->with('datosActuales', $datos);
            }
        } else {
            //si ya existe la llave entonces eliminará los datos duplicados
            $respuesta = Datos::where('puertos', $datos['puertos'])->get();
            foreach ($respuesta as $valor) {
                Datos::destroy($valor['id']);
            }

            unset($datos['llave']); //elimina la llave de los datos
            DatosController::cambiarEstado();
            Datos::insert($datos); //guarda los datos
            return redirect('servicio');
        }
    }

    /**
     * cambia el estado del registro anterior a false para que el
     * nuevo registro sea true y se resalte en vista.
     */
    private function cambiarEstado()
    {
        $last = Datos::where('islast', true)->get();
        foreach ($last as $valor) {
            Datos::where('id', $valor->id)->update(['islast' => false]);
        }
    }

    //devuelve el nombre del técnico según su valor
    private function tecnicos($index)
    {
        $nombre = [
            '1' => 'FABIAN FONSECA',
            '2' => 'DANIEL CHACÓN',
            '3' => 'DIEGO DELGADO',
            '4' => 'JHONY ULLOQUE',
            '5' => 'CARLOS ARAQUE',
            '6' => 'IVAN BARRERA'
        ];
        return $nombre[$index];
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Datos  $datos
     * @return \Illuminate\Http\Response
     */
    public function show(Datos $datos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Datos  $datos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos = Datos::findOrFail($id);

        return view('servicio.edit', compact('datos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Datos  $datos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Datos $datos, $id)
    {
        $datos = request()->except('_token', '_method');
        $datos['tecnico'] = DatosController::tecnicos($datos['tecnico']);
        $datos += ['fecha' => Carbon::today()->format('Y-m-d')];
        DatosController::cambiarEstado();
        Datos::where('id', '=', $id)->update($datos);
        return redirect('/consultar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Datos  $datos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Datos::destroy($id);
        return redirect('/consultar');
    }
}
