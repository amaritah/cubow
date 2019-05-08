<?php

namespace AlbaVending\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'password' => 'required|confirmed|min:6',
                    'role_id' => 'required',
                ];
            case 'PATCH':
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'password' => 'required|confirmed|min:6',
                    'role_id' => 'required',
                ];
            default:break;
        }

        
    }
}
