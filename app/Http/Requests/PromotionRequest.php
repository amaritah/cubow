<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PromotionRequest extends Request
{

    /**
     * Pediremos que el nombre, el piso y el vector del plano sean obligatorios.
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'description' => 'required',
            'room_id' => 'required',
        ];
    }
}
