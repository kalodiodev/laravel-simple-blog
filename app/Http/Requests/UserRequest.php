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
        if($this->method() == 'PATCH')
        {
            return $this->patch_rules();
        }

        return [
            'name' => 'required|max:190',
            'email' => 'required|email|max:190|unique:users',
            'about' => 'max:190',
            'profession' => 'max:50',
            'country' =>  'max:25',
            'avatar' => 'mimes:jpeg,png'
        ];
    }

    /**
     * Validation rules for patch method
     * 
     * @return array
     */
    protected function patch_rules()
    {
        $user = $this->route()->parameter('user');

        return [
            'name' => 'required|max:190',
            'email' => 'required|email|max:190|unique:users,email,'.$user->id,
            'about' => 'max:190',
            'profession' => 'max:50',
            'country' =>  'max:25',
            'avatar' => 'mimes:jpeg,png'
        ];
    }
}
