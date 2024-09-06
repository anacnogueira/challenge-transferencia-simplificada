<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\UserService;
use App\Rules\HasCpf;

class TransferWalletRequest extends FormRequest
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
            'value' => ['required', 'decimal:2'],
            'payer' => ['required', 'numeric', 'exists:App\Models\User,id', new HasCpf],
            'payee' => ['required', 'numeric', 'exists:App\Models\User,id'],
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
