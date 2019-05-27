<?php

namespace App\Http\Controllers;
/*
 * Es necesario que algunos modelos estén cargados.
 * A promociones e imágenes de sala accedo mediante Sala, así que no son necesarios.
 */
use App\Floor; 
use App\Room; 
use App\Score; 
use App\Category; 
use App\Promotion; 

use XMLWriter; 
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
           $floor['rooms'] = Room::with('promotions')->with('images')->where('floor_id', $floor->id)->orderBy('name', 'asc')->get();
            return $floor;
        });
        $data['floors'] = $floors;
        $data['categories'] = Category::all();
        /*
         * Dependiendo del tipo de dato solicitado, exporto en un sistema u otro.
         */
        if ($type == 'xml'){
            header('Content-type: text/xml');
            header('Content-Disposition: attachment; filename=floors.xml');
            // Basado en https://stackoverflow.com/questions/15961390/export-xml-from-mysql-with-php
            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->startDocument('1.0','UTF-8');
            
            // Movemos las categorías a un array asociativo por id, para poder acceder al dato después.
            $categoriesArray = [];
            foreach ($data['categories'] as $category){
                $categoriesArray[$category->id] = $category->name;
            }
            
            foreach ($floors as $floor){
                $xml->startElement('floor'); // Iniciamos piso
                $xml->writeAttribute('name',$floor->name);
                $xml->writeAttribute('abbreviation',$floor->abbreviation);
                
                foreach ($floor->rooms as $room){
                    $xml->startElement('room'); // Iniciamos sala
                    $xml->writeAttribute('name',$room->name);
                    $xml->writeAttribute('description',$room->description);
                    $xml->writeAttribute('email',$room->email);
                    $xml->writeAttribute('phone',$room->phone);
                    $xml->writeAttribute('category', $categoriesArray[$room->category_id]);
                    
                    foreach ($room->images as $image){
                        $xml->startElement('image'); // Iniciamos imagen
                        $xml->writeAttribute('img_path',$image->img_path);
                        $xml->endElement(); // Finalizamos imagen
                    }
                    foreach ($room->promotions as $promotion){
                        $xml->startElement('promotion'); // Iniciamos promoción
                        $xml->writeAttribute('name',$promotion->name);
                        $xml->writeAttribute('description',$promotion->description);
                        $xml->writeAttribute('img_path',$promotion->img_path);
                        $xml->endElement(); // Finalizamos promoción
                    }
                    
                    $xml->endElement(); // Finalizamos sala
                }
                
                $xml->endElement();  // Finalizamos piso
                
            }
            $xml->endDocument();
            echo $xml->outputMemory();
        } else{
            echo json_encode($data);
        }
    }
    /*
     * Función sencilla para insertar un voto.
     */
    public function vote(PublicRequest $request){
        $score = new Score;
        $score->score = $request->get('score');
        $score->save();
    }
    
    /*
     * Función para consumir una promoción, actualizando los usos.
     */
    public function showPromo(PublicRequest $request, $id){
        $promotion = Promotion::find($id);
        /*
         * Si la promoción no existe, redirigimos al usuario a la home.
         */
        if (!$promotion){
            return redirect()->route('welcome');
        }
        $promotion->uses++;
        $promotion->save();
        
        return view('promotion', ['promotion' => $promotion]);
    }
}