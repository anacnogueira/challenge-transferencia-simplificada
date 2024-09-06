<?php

namespace App\Rules;

use Closure;
use App\Services\UserService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;

class HasCpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userService = App::make('App\Repositories\Contracts\UserRepositoryInterface');

        $user = $userService->getUserById($value);
       
        if(!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $user->cpf_cnpj)) {
            $fail('This user cannot make a transfer.');
        }
    }
}
