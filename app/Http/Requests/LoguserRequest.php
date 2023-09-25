<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoguserRequest extends FormRequest
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
            
            'email'=>'required|email|exists:users,email',
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
            'email.required'=>'email non fourni',
            'email.email'=>'adresse email non valide',
            'email.exists'=>'cette adresse email n\'existe pas',
            'password.required'=>'un mot de passe doit etre fourni'
            
           

        ];

    }
}
