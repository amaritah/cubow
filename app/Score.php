<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';
    /*
     * Se especifican los distintos campos rellenables del formulario
     * 
     */
    protected $fillable = [
        'score'
    ];
    
}
