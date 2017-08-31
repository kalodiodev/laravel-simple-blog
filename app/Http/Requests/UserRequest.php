<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:190',
            'email' => 'required|email|max:190|unique:users',
            'about' => 'max:190',
            'profession' => 'max:50',
            'country' =>  'max:25',
            'avatar' => 'mimes:jpeg,png',
            'password' => 'required|string|min:6|max:190|confirmed',
        ];
        
        if($this->method() == 'PATCH')
        {
            $user = $this->route()->parameter('user');
            
            $rules['email'] = 'required|email|max:190|unique:users,email,'.$user->id;
            $rules['password'] = 'nullable|string|min:6|max:190|confirmed';
        }

        return $rules;
    }
}
