<?php
namespace App\Http\Requests;

use App\Enums\QuoteStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'artist_id' => 'nullable|exists:artists,id', 'price' => 'nullable|numeric|min:0|max:1000000',
            'deposit' => 'nullable|numeric|min:0|lte:price', 'status' => ['required', Rule::enum(QuoteStatus::class)],
            'admin_note' => 'nullable|string|max:2000',
        ];
    }
}
