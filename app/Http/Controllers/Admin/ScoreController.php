<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
/*
 * Es necesario cargar todos los modelos, pues vamos a contearlos.
 */
use App\Score;
use App\Room; 
use App\Promotion; 
use App\User; 
use App\Floor; 
use App\Category; 
/*
 * La inclusión del PromotionRequest nos permite realizar validaciones de los campos.
 * Tanto la Gate como Auth serán necesarios para poder validar a los Dueños, editando y viendo solo sus salas. Además, no podrán crear.
 */
use App\Http\Requests\ScoreRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class ScoreController extends AdminController {

    public function index()
    {
        /*
         * Mediante Auth::user() conocemos si el usuario está loggeado. 
         * En caso de que no esté loggeado, le obligamos a ello devolviendo la vista de login. 
         * En caso de que ya esté loggeado, le devolvemos la vista del panel de administración. 
         */
        if (Auth::user()){
            if (Auth::user()->role_id == 1){
                /*
                 * Obtenemos todos los datos del sistema para el Dashboard. En principio solo se van a contar, pero podríamos usarlos para obtener información 
                 * más concreta respecto a ellos.
                 */
                $data['scores1'] = Score::where('score', 1)->get();
                $data['scores2'] = Score::where('score', 2)->get();
                $data['scores3'] = Score::where('score', 3)->get();
                $data['users'] = User::all();
                $data['rooms'] = Room::all();
                $data['floors'] = Floor::all();
                $data['promotions'] = Promotion::all();
                $data['categories'] = Category::all();
                
                return view('admin.index', $data);
            } else{
                return redirect('/admin/rooms');
            }
        } else {
            return view('admin.login');
        }
    }
}