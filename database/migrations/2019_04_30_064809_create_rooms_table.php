<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable(); // Puede ser nulo, si es una sala sin asignar
            $table->unsignedBigInteger('floor_id');
            $table->longText('scheme'); // Utilizo text ya que pienso vectorizar planos, y no sé cuanto me ocupará de espacio.
            $table->string('name', 50);
            $table->longText('description'); // Utilizo text, porque la descripción es HTML, pudiendo ocupar mucho espacio.
            $table->string('phone', 15);
            $table->string('email', 50);
            $table->timestamps();
            
            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade'); // En caso de borrar una planta, borramos sus salas asociadas.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // En caso de que se borre el usuario dueño, la sala no se borra, se pierde la relación
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
