<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreWalletRequest extends FormRequest
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
            'user_id' => ['required', 'numeric', 'exists:App\Models\User,id','unique:wallets'],
            'amount' => ['required', 'decimal:2']
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo é obrigatório',
            'numeric' => 'O campo deve ser um número',
            'decimal' => 'O campo deve ser um valor com 2 casas decimais',
            'exists' => 'Usuário não encontrado',
            'unique' => 'O usuário já possui uma carteira.',
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
