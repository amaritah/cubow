<?php

namespace App\Http\Controllers;
/*
 * Es necesario que algunos modelos estén cargados.
 * A promociones e imágenes de sala accedo mediante Sala, así que no son necesarios.
 */
use App\Floor; 
use App\Room; 
use App\Score; 

use App\Http\Requests\PublicRequest;


class PublicController extends Controller
{
    public function index(){
        return view ('welcome');
    }
    
    /*
     * Función encargada de obtener y procesar todos los datos para la parte pública.
     */
    public function obtainData(PublicRequest $request){
        $type = $request->get('type');
        /*
         * Obtengo todos los datos pertinentes.
         * Primero, los pisos
         * Luego, por cada piso, obtengo sus salas con sus respectivas imágenes y promociones.
         */
        $floors = Floor::all();
        
        $floors->map(function($floor){
           $floor['rooms'] = Room::with('promotions')->with('images')->where('floor_id', $floor->id)->get();
            return $floor;
        });
        /*
         * Dependiendo del tipo de dato solicitado, exporto en un sistema u otro.
         */
        if ($type == 'xml'){
            
        } elseif ($type == 'xls'){
            
        } else{
            echo json_encode($floors);
        }
    }
}