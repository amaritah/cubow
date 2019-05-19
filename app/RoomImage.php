<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    protected $table = 'room_images';
    public $timestamps = false;
    /*
     * Se especifican los distintos campos rellenables del formulario
     */
    protected $fillable = [
        'room_id', 'img_path'
    ];
    
    /*
     * Método necesarios para realizar las relaciones
     */
    
    public function room() {
      return $this->belongsTo(Room::class);
    }
}
