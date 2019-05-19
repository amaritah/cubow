<?php
/*
 * Extiendo (para ello incluyo) el controlador del panel de administración, simplemente para no repetir el comienzo del archivo, 
 * y añadirle únicamente lo que hace a este controlador distinto.
 * El namespace es necesario para tenerlos agrupados.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
/*
 * Es necesario que el modelo de Sala esté cargado. También el de pisos y el de usuarios para poder rellenar sus selectores
 */
use App\Room;
use App\User;
use App\Floor;
/*
 * La inclusión del RoomRequest nos permite realizar validaciones de los campos.
 * Tanto la Gate como Auth serán necesarios para poder validar a los Dueños, editando y viendo solo sus salas. Además, no podrán crear.
 */
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class RoomController extends AdminController
{
    /*
     * Los campos que son editables en el formulario. Se inicializan vacíos para poder añadir usando la misma plantilla que para editar.
     */
    protected $fields = [
        'name'  => '',
        'description' => '',
        'floor_id' => '',
        'user_id' => '',
        'email' => '',
        'phone' => '',
        'scheme' => '',
    ];
    
    public function index()
    {
        /*
         * Si es dueño de sala, solo obtiene las suyas.
         */
        $rooms = (Gate::allows('admin-only', Auth::user()))? Room::has('floor')->get(): Room::where('user_id', Auth::user()->id)->has('floor')->get();
        $rooms->map(function ($room) {
            $room['user'] = ($room['user_id'])? User::find($room['user_id']): new User;
            return $room;
        });
        return view('admin.rooms.index', ['selectedMenu' => 'rooms'])->withRooms($rooms);
    }
    
    public function detail($id = null)
    { 
        /*
         * En caso de que no sea administrador, solo se permite acceder a detalles de sus salas.
         */
        $room = ($id)? Room::find($id): new Room;
        if (Gate::allows('admin-only', Auth::user()) || $room->user_id == Auth::user()->id){
            
            $data = ['id' => $id];
            foreach (array_keys($this->fields) as $field) {
              $data[$field] = old($field, $room->$field);
            }
            /*
             * Hay que transmitir los pisos y usuarios de tipo dueño. En caso de ser dueño, solo se obtiene a sí mismo.
             */
            $data['floors'] = Floor::all();
            $data['users'] = (Gate::allows('admin-only', Auth::user()))? User::where('role_id', '2')->get(): User::where('user_id', Auth::user()->id);
            $data['disabled'] = !Gate::allows('admin-only', Auth::user());

            return view('admin.rooms.detail', $data);
        }
        else {
            return redirect()->route('admin.rooms');
        }
    }
    
    public function store(RoomRequest $request)
    {
        /*
         * Se inserta una nueva sala
         */
        $room = new Room;

        foreach (array_keys($this->fields) as $field) {
            $room->$field = $request->get($field);
        }

        $room->save();
        return redirect()->route('admin.rooms')->withSuccess('Nueva sala creada sin problemas.');
    }

    public function update(RoomRequest $request, $id)
    {
        /*
         * Se actualiza la sala, recogiendo sus valores validados por RoomRequest
         */
        $room = Room::find($id);

        foreach (array_keys($this->fields) as $field) {
            $room->$field = $request->get($field);
        }

        $room->save();

        return redirect()->route('admin.rooms')->withSuccess('Sala editada sin problemas.');
    }

    public function destroy($id)
    {
        Room::destroy($id);
        return redirect()
            ->route('admin.rooms')
            ->withSuccess('Sala borrada sin problemas.');
    }

}
