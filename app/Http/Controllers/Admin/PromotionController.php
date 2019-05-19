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
 * La inclusión del RoomRequest nos permite realizar validaciones de los campos.
 * Tanto la Gate como Auth serán necesarios para poder validar a los Dueños, editando y viendo solo sus salas. Además, no podrán crear.
 */
use App\Http\Requests\RoomRequest;
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
    ];
    
    public function index()
    {
        /*
         * Si es dueño de sala, solo obtiene las suyas. Para ello es necesario un left join con la tabla salas, a través de su id pertinente.
         * Con la sala en la query, hay que comprobar que la sala pertenezca al usuario concreto.
         */
        $promotions = (Gate::allows('admin-only', Auth::user()))? Promotion::has('room')->get(): 
            Promotion::has('room')->leftJoin('rooms', 'rooms.id', '=', 'promotions.room_id')->where('rooms.user_id', Auth::user()->id)->get();

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
              $data[$field] = old($field, $room->$field);
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
            $promotion->$field = $request->get($field);
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

}
