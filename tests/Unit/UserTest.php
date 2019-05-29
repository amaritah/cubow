<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
/*
 * Librería para crear datos de test: https://laravel.com/docs/5.8/database-testing
 */
use Faker\Factory as Faker;

class RoomTest extends TestCase
{
    /*
     * Testeo de CRUD completo de usuarios. Realiza una creación, edición y eliminación. 
     * En caso de que se editará el modelo de datos o se cambiaran los campos requeridos, este test fallaría.
     */
    public function testUserCRUD(){
        echo "\nComienzo CRUD usuarios.";
        $faker = Faker::create();
        $user = new User;
        
        $user->name = $faker->name;
        $user->email = $faker->unique()->email;
        $user->password = $faker->name;
        $user->role_id = 1;
        
        if ($user->save()){
            echo "\nUsuario creado con éxito.";
            $this->assertTrue(true);
        } else {
            echo "\nProblema al crear el usuario.";
            $this->assertTrue(false);
        }
        
        $user->role_id = 2;
        
        if ($user->save()){
            echo "\nUsuario editado con éxito.";
            $this->assertTrue(true);
        } else {
            echo "\nProblema al editar el usuario.";
            $this->assertTrue(false);
        }
        
        if (User::destroy($user->id)){
            echo "\nUsuario eliminado con éxito.";
            $this->assertTrue(true);
        } else {
            echo "\nProblema al eliminar el usuario.";
            $this->assertTrue(false);
        }
        echo "\nFin CRUD usuarios.";
    }
}