<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $table = 'floors';
    protected $fillable = [
        'name', 'abbreviation',
    ];
    
    public function rooms(){
        return $this->hasMany('App\Room');
    }
}
