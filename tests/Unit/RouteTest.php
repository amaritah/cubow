<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Promotion;
use App\User;
use App\Room;
use App\Floor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    /*
     * Test que prueba todas las rutas de la parte pública.
     * Por un lado, prueba las URL en GET, por otro lado las URL en POST.
     * Todo esto hasido basándome en https://laravel.com/docs/5.8/http-tests
     */
    public function testPublicRoutes()
    {
        $return = "\nComienzo testeo rutas.";
        /*
         * Necesitamos una variable para imprimir en pantalla y realizar ob_start() y ob_end_clean() porque pasamos por URL JSON y se imprimen en consola.
         */
        ob_start();
        /*
         * La appURL la utilizamos para imprimirla en los resultados.
         */
        $appURL = env('APP_URL');
        /*
         * URLS GET. Se tratan distintas que las POST. En caso de que devuelvan estado 200, es éxito. En caso contrario, hay un fallo.
         */
        $urlsGet = [
            '/',
            '/obtain-data'
        ];
        /*
         * Añado todas las url posibles de promociones.
         */
        foreach (Promotion::all() as $promo){
            $urlsGet[] = '/promotion/'.$promo->id;
        }
        foreach ($urlsGet as $url) {
            $response = $this->get($url);
            if((int)$response->status() !== 200){
                $return .= $appURL.$url." Ha fallado. Ha devuelto estado ".(int)$response->status().".\n";
                $this->assertTrue(false);
            } else {
                $return .= $appURL.$url." OK.\n";
                $this->assertTrue(true);
            }
        }
        /*
         * URLS Post. En lugar de un get, se realiza un CALL. Es necesario que lleven el CSRF TOKEN.
         */
        $urlsPost = [
          '/vote'  
        ];
        foreach ($urlsPost as $url) {
            
            $response = $this->call('POST', $url, array('_token' => csrf_token(),));
            if((int)$response->status() !== 200){
                $this->assertTrue(false);
                $return .= $appURL.$url." Ha fallado. Ha devuelto estado ".(int)$response->status().".\n";
            } else {
                $return .= $appURL.$url." OK.\n";
                $this->assertTrue(true);
            }
        }
        ob_end_clean();
        echo $return;
    }
    
    /*
     * Test que prueba todas las rutas de la parte privada.
     * En este caso voy a probar solo las GET.
     */
    public function testAdminRoutes()
    {
        $appURL = env('APP_URL');
        echo "\n";
        /*
         * URLS GET. Se tratan distintas que las POST. En caso de que devuelvan estado 200, es éxito. En caso contrario, hay un fallo.
         */
        $urlsGet = [
            '/admin/users',
            '/admin/user/new',
            '/admin/profile',
            '/admin/floors',
            '/admin/rooms',
            '/admin/promotions',
            '/admin/promotions/new'
        ];
        /*
         * Usuario administrador que forzaremos para las peticiones.
         */
        $userAdmin = new User;
        $userAdmin->role_id = 1;
        $userAdmin->make();
        /*
         * Bucleamos todas las URL posibles del panel de administración.
         */
        foreach (Promotion::all() as $promotion){
            $urlsGet[] = '/admin/promotions/'.$promotion->id.'/edit';
        }
        foreach (User::all() as $user){
            $urlsGet[] = '/admin/user/'.$user->id.'/edit';
        }
        foreach (Room::all() as $room){
            $urlsGet[] = '/admin/rooms/'.$room->id.'/edit';
        }
        foreach (Floor::all() as $floor){
            $urlsGet[] = '/admin/floors/'.$floor->id.'/edit';
        }
        foreach ($urlsGet as $url) {
            /*
             * Debido a que vamos al panel de administración, debemos forzar la entrada con un usuario administrador para las peticiones.
             */
            $response = $this->actingAs($userAdmin)
                ->withSession(['foo' => 'bar'])
                ->get($url);
            if((int)$response->status() !== 200){
                echo $appURL.$url." Ha fallado. Ha devuelto estado ".(int)$response->status().".\n";
                $this->assertTrue(false);
            } else {
                echo $appURL.$url." OK.\n";
                $this->assertTrue(true);
            }
        }
    }
}