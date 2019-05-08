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

class UserController extends AdminController
{

    protected $fields = [
        'name'  => '',
        'role_id' => '',
        'email' => '',
    ];
    
    public function index()
    {
        return view('admin.users.index', ['selectedMenu' => 'users'])
          ->withUsers(User::all());
    }
    
    public function detail($id = null)
    { 
        $user = ($id)? User::find($id): new User;
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
          $data[$field] = old($field, $user->$field);
        }
        $data['roles'] = Role::all();

        return view('admin.users.detail', $data);
    }

    public function store(UserRequest $request)
    {
        $user = new User;

        foreach (array_keys($this->fields) as $field) {
          $user->$field = $request->get($field);
        }
        $user->password = bcrypt($request->input('password'));

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->withSuccess('Nuevo usuario creado sin problemas.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'confirmed|min:6',
        ]);

        foreach (array_keys($this->fields) as $field) {
          $user->$field = $request->get($field);
        }

        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->withSuccess('Usuario editado sin problemas.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()
            ->route('admin.users.index')
            ->withSuccess('Usuario borrado sin problemas.');
    }

}
