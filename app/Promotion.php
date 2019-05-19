<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    /*
     * Se especifican los distintos campos rellenables del formulario
     * 
     */
    protected $fillable = [
        'name', 'description','room_id', 'img_path', 'qr', 'start', 'end', 'uses'
    ];
    
    /*
     * Método necesarios para realizar las relaciones
     */
    
    public function room() {
      return $this->belongsTo(Room::class);
    }
}
