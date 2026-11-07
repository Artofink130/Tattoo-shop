<?php
namespace App\Http\Requests;

use App\Enums\Coin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'coin' => ['required', Rule::enum(Coin::class)],
            'txid' => ['required', 'string', 'max:200', 'regex:/^[A-Za-z0-9]+$/', 'unique:payments,txid'],
        ];
    }
}
