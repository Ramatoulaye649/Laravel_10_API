<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class CreatePostRequest extends FormRequest
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
            'titre'=>'required'
        ];
    }
    public function failedvalidation(validator $validator){
        throw new HttpResponseException(response()->json([
            'success'=>'false',
            'error'=>'true',
            'message'=>'erreur de validation',
            'errorsList'=>$validator->errors()

        ]));
    }

    public function messages(){
        return[
            'titre.required'=>'un titre doit etre fourni'

        ];

    }
}
