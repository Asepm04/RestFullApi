<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseExcepion;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() != null;
    } 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "first_name"=>["nullable","max:100"],
            "last_name"=>["nullable","max:100"],
            "phone"=>["nullable","max:100"],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpExceptionResponse(
            response()->json([
                $validator->getMessageBag()
            ],400)
        );
    }
}
