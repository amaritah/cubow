<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    /*
     * Se especifican los distintos campos rellenables del formulario
     */
    protected $fillable = [
        'name', 'description','room_id', 'scheme', 'phone', 'email', 'user_id'
    ];
    
    /*
     * Método necesarios para realizar las relaciones
     */
    
    public function floor() {
      return $this->belongsTo(Floor::class);
    }
    
    public function promotions(){
        return $this->hasMany(Promotion::class);
    }
    public function images(){
        return $this->hasMany(RoomImage::class);
    }
}
