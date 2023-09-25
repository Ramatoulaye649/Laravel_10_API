<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ResisterUser extends FormRequest
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
    public function rules():array
    {
        return [
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required'
        ];
    }
    public function failedvalidation(validator $validator){
        throw new HttpResponseException(response()->json([
            'success'=>'false',
            'status_code'=>422,
            'error'=>'true',
            'message'=>'erreur de validation',
            'errorsList'=>$validator->errors()

        ]));
    }

    public function messages(){
        return[
            'name.required'=>'un nom doit etre fourni',
            'email.required'=>'une adresse email doit etre fourni',
            'email.unique'=>'cette adresse mail existe deja',
            'password.required'=>'le mot de passe est requis'

        ];

    }
}
