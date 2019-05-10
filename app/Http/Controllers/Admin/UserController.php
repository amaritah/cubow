<?php
/*
 * Extiendo (para ello incluyo) el controlador del panel de administración, simplemente para no repetir el comienzo del archivo, 
 * y añadirle únicamente lo que hace a este controlador distinto.
 * El namespace es necesario para tenerlos agrupados.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
/*
 * Es necesario que el modelo de Usuario este cargado. Cargamos también el modelo Rol, para poder rellenar su selector.
 */
use App\User;
use App\Role;
/*
 * La inclusión del UserRequest nos permite realizar validaciones de los campos.
 */
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class UserController extends AdminController
{

    protected $fields = [
        'name'  => '',
        'role_id' => '',
        'email' => '',
    ];
    
    public function index()
    {
        if (Gate::allows('admin-only', Auth::user()))
            return view('admin.users.index', ['selectedMenu' => 'users'])->withUsers(User::has('role')->get());
        else 
            return redirect()->route('admin.rooms');
    }
    
    public function detail($id = null, $selectedMenu = 'users')
    { 
        if (Gate::allows('admin-only', Auth::user()) || $selectedMenu == 'profile'){
            $user = ($id)? User::find($id): new User;
            $data = ['id' => $id];
            foreach (array_keys($this->fields) as $field) {
              $data[$field] = old($field, $user->$field);
            }
            $data['roles'] = Role::all();
            $data['selectedMenu'] = $selectedMenu;

            return view('admin.users.detail', $data);
        }
        else 
            return redirect()->route('admin.rooms');
    }
    
    public function profile()
    { 
        if (!Auth::user())
            return redirect()->route('admin');
        return $this->detail(Auth::user()->id, 'profile');
    }

    public function store(UserRequest $request)
    {
        $user = new User;

        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        $user->password = bcrypt($request->input('password'));

        $user->save();

        return redirect()->route('admin.users')->withSuccess('Nuevo usuario creado sin problemas.');
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }

        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        return redirect()->route('admin.users')->withSuccess('Usuario editado sin problemas.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()
            ->route('admin.users')
            ->withSuccess('Usuario borrado sin problemas.');
    }

}
