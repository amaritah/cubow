<?php
/*
 * Extiendo (para ello incluyo) el controlador del panel de administración, simplemente para no repetir el comienzo del archivo, 
 * y añadirle únicamente lo que hace a este controlador distinto.
 * El namespace es necesario para tenerlos agrupados.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
/*
 * Es necesario que el modelo de Promoción esté cargado. También el de salas
 */
use App\Promotion;
use App\Room; 
/*
 * La inclusión del PromotionRequest nos permite realizar validaciones de los campos.
 * Tanto la Gate como Auth serán necesarios para poder validar a los Dueños, editando y viendo solo sus salas. Además, no podrán crear.
 */
use App\Http\Requests\PromotionRequest;
use App\Http\Requests\RoomImageRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class PromotionController extends AdminController
{
    /*
     * Los campos que son editables en el formulario. Se inicializan vacíos para poder añadir usando la misma plantilla que para editar.
     */
    protected $fields = [
        'name'  => '',
        'description' => '',
        'room_id' => '',
        'img_path' => '',
        'qr' => '',
        'start' => '',
        'end' => '',
        'uses' => '',
    ];
    
    public function index()
    {
        /*
         * Si es dueño de sala, solo obtiene las suyas. Para ello es necesario un left join con la tabla salas, a través de su id pertinente.
         * Con la sala en la query, hay que comprobar que la sala pertenezca al usuario concreto.
         */
        $promotions = (Gate::allows('admin-only', Auth::user()))? Promotion::has('room')->get(): 
            Promotion::whereHas('room', function($query) { $query->where('user_id', Auth::user()->id); })->get();
        return view('admin.promotions.index', ['selectedMenu' => 'promotions'])->withPromotions($promotions);
    }
    
    public function detail($id = null)
    { 
        /*
         * En caso de que no sea administrador, solo se permite acceder a detalles de las promociones de sus salas
         */
        $promotion = ($id)? Promotion::find($id): new Promotion;
        $room = ($id)? Room::find($promotion->room_id): new Room;
        if (Gate::allows('admin-only', Auth::user()) || $room->user_id == Auth::user()->id || !$id){
            
            $data = ['id' => $id];
            foreach (array_keys($this->fields) as $field) {
                if (($field == 'start' && $promotion->start) || ($field == 'end' && $promotion->end)){
                    $data[$field] = date("d/m/Y", strtotime($promotion->$field));
                } else {
                    $data[$field] = old($field, $promotion->$field);
                }
            }
            /* 
             * Hay que transmitir las salas a las que se tiene acceso.
             */
            $data['rooms'] = (Gate::allows('admin-only', Auth::user()))? Room::all(): Room::where('user_id', Auth::user()->id)->get();
            return view('admin.promotions.detail', $data);
        }
        else {
            return redirect()->route('admin.rooms');
        }
    }
    
    public function store(PromotionRequest $request)
    {
        /*
         * Se inserta una nueva sala
         */
        $promotion = new Promotion;

        foreach (array_keys($this->fields) as $field) {
            $promotion->$field = $request->get($field);
        }
        /*
         * Cambio el formato de fechas, al propio de SQL
         */
        if ($promotion->start){
            $date = str_replace('/', '-', $promotion->start );
            $promotion->start = date("Y-m-d", strtotime($date));
        }
        if ($promotion->end){
            $date = str_replace('/', '-', $promotion->end );
            $promotion->end = date("Y-m-d", strtotime($date));
        }

        $promotion->save();
        return redirect()->route('admin.promotions')->withSuccess('Nueva promoción creada sin problemas.');
    }

    public function update(PromotionRequest $request, $id)
    {
        /*
         * Se actualiza la promoción, recogiendo sus valores validados por PromotionRequest
         */
        $promotion = Promotion::find($id);

        foreach (array_keys($this->fields) as $field) {
            if ($field != 'img_path'){
                $promotion->$field = $request->get($field);
            }
        }
        /*
         * Cambio el formato de fechas, al propio de SQL
         */
        if ($promotion->start){
            $date = str_replace('/', '-', $promotion->start );
            $promotion->start = date("Y-m-d", strtotime($date));
        }
        if ($promotion->end){
            $date = str_replace('/', '-', $promotion->end );
            $promotion->end = date("Y-m-d", strtotime($date));
        }
            

        $promotion->save();

        return redirect()->route('admin.promotions')->withSuccess('Promoción editada sin problemas.');
    }

    public function destroy($id)
    {
        Promotion::destroy($id);
        return redirect()
            ->route('admin.promotions')
            ->withSuccess('Promoción borrada sin problemas.');
    }
    
    
    /*
    * Esté código lo he cogido de https://appdividend.com/2018/05/31/laravel-dropzone-image-upload-tutorial-with-example/
    */
    public function fileStore(RoomImageRequest $request, $id){
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images/promotions'),$imageName); 
        
        $promotion = Promotion::find($id);
        $promotion->img_path = '/images/promotions/'.$imageName;
        $promotion->save();
        return response()->json(['success'=>$imageName]);
    }
    public function fileDestroy(RoomImageRequest $request)
    {
        $filename =  $request->get('filename');
        $promotion = Promotion::where('img_path','/images/promotions/'.$filename)->first();
        $promotion->img_path = '';
        $promotion->save();
        $path=public_path().'/images/promotions'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    }

}
