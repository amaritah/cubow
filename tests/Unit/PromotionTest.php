<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Promotion;
use App\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
/*
 * Librería para crear datos de test: https://laravel.com/docs/5.8/database-testing
 */
use Faker\Factory as Faker;

class PromotionTest extends TestCase
{
    /*
     * Testeo de CRUD completo de promociones. Realiza una creación, edición y eliminación. 
     * En caso de que se editará el modelo de datos o se cambiaran los campos requeridos, este test fallaría.
     */
    public function testPromotionCRUD(){
        echo "\nComienzo CRUD promociones";
        $faker = Faker::create();
        $promotion = new Promotion;
        /*
         * Dará error siempre que la sala no exista, así que cogemos una aleatoria.
         */
        $promotion->room_id = Room::all()->random(1)[0]->id;
        $promotion->name = $faker->name;
        $promotion->description = $faker->text;
        $promotion->qr = 0;
        $promotion->uses = $faker->randomDigit;
        
        if ($promotion->save()){
            echo "\nPromoción creada con éxito.";
            $this->assertTrue(true);
        } else {
            echo "\nProblema al crear la promoción.";
            $this->assertTrue(false);
        }
        
        $promotion->qr = 1;
        $promotion->uses = $faker->randomDigit;
        
        if ($promotion->save()){
            echo "\nPromoción editada con éxito.";
            $this->assertTrue(true);
        } else {
            echo "\nProblema al editar la promoción.";
            $this->assertTrue(false);
        }
        
        if (Promotion::destroy($promotion->id)){
            echo "\nPromoción eliminada con éxito.";
            $this->assertTrue(true);
        } else {
            echo "\nProblema al eliminar la promoción.";
            $this->assertTrue(false);
        }
        echo "\nFin CRUD promociones";
    }
}