<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreUpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                'unique:users',
                'max:255'],
            'password' => ['required'],    
            'cpf_cnpj' => ['required', 'formato_cpf_ou_cnpj'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo é obrigatório',
            'string' => 'O campo deve ser do tipo string',
            'email' => 'O campo deve ser obrigatoriamente um e-mail',
            'unique' => 'O campo :attribute deve ser único.',
        ];
    }

    /**
     * Transform the error messages into JSON
     *
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
