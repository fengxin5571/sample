<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPatch extends FormRequest
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
        return [
            //
            'name'=>"required|max:50",
            'password'=>'nullable|confirmed|min:6|different:password',
            'sex'=>'required'
            
        ];
    }
    public function messages(){
        return [
            'password.different'=>'如要修改密码，需要和原密码不同',
        ];
    }
    
}
