<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id');
            $table->string('name', 50);
            $table->longText('description'); // Utilizo text, porque la descripción es HTML, pudiendo ocupar mucho espacio.
            $table->string('img_path', 50);
            $table->boolean('qr'); 
            $table->date('start')->nullable(); // En caso de ser nula, se mostrará siempre
            $table->date('end')->nullable(); // En caso de ser nula, se mostrará siempre
            $table->timestamps();
            
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade'); // En caso de borrar una sala, borramos sus promociones asociadas.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
