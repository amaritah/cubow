<?php
/*
 * Extiendo (para ello incluyo) el controlador del panel de administración, simplemente para no repetir el comienzo del archivo, 
 * y añadirle únicamente lo que hace a este controlador distinto.
 * El namespace es necesario para tenerlos agrupados.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
/*
 * Es necesario que el modelo de Piso esté cargado
 */
use App\Floor;
/*
 * La inclusión del FloorRequest nos permite realizar validaciones de los campos.
 */
use App\Http\Requests\FloorRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class FloorController extends AdminController
{
    /*
     * Los campos que son editables en el formulario
     */
    protected $fields = [
        'name'  => '',
        'abbreviation' => '',
    ];
    
    public function index()
    {
        /*
         * Si no tiene permiso, se redirecciona al usuario a salas.
         */
        if (Gate::allows('admin-only', Auth::user())){
            return view('admin.floors.index', ['selectedMenu' => 'floors'])->withFloors(Floor::all());
        }
        else {
            return redirect()->route('admin.rooms');
        }
    }
    
    public function detail($id = null)
    { 
        /*
         * Si no tiene permiso, se redirecciona al usuario a salas.
         * En caso de estar añadiendo un nuevo piso, los campos estarán vacíos. En caso contrario (edición), tendrán su respectivo valor.
         */
        if (Gate::allows('admin-only', Auth::user())){
            $floor = ($id)? Floor::find($id): new Floor;
            $data = ['id' => $id];
            foreach (array_keys($this->fields) as $field) {
              $data[$field] = old($field, $floor->$field);
            }

            return view('admin.floors.detail', $data);
        }
        else {
            return redirect()->route('admin.rooms');
        }
    }
    
    public function store(FloorRequest $request)
    {
        /*
         * Se inserta un nuevo piso, recogiendo sus valores validados por FloorRequest
         */
        $floor = new Floor;

        foreach (array_keys($this->fields) as $field) {
            $floor->$field = $request->get($field);
        }

        $floor->save();
        return redirect()->route('admin.floors')->withSuccess('Nuevo piso creado sin problemas.');
    }

    public function update(FloorRequest $request, $id)
    {
        /*
         * Se actualiza el piso, recogiendo sus valores validados por FloorRequest
         */
        $floor = Floor::find($id);

        foreach (array_keys($this->fields) as $field) {
            $floor->$field = $request->get($field);
        }

        $floor->save();

        return redirect()->route('admin.floors')->withSuccess('Piso editado sin problemas.');
    }

    public function destroy($id)
    {
        Floor::destroy($id);
        return redirect()
            ->route('admin.floors')
            ->withSuccess('Piso borrado sin problemas.');
    }

}
