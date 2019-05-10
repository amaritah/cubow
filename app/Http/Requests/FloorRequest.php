<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FloorRequest extends Request
{

    /**
     * Pediremos que el nombre y la abreviatura sean obligatorios.
     */
    public function rules()
    {
        return [
            'name' => 'required|max:25',
            'abbreviation' => 'required|max:5'
        ];
    }
}
