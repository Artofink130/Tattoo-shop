<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100', 'email' => 'required|email|max:150',
            'country' => 'required|string|max:60', 'city' => 'required|string|max:80',
            'idea' => 'required|string|max:3000', 'style' => ['required', Rule::in(config('studio.styles'))],
            'placement' => 'required|string|max:100', 'size' => 'required|string|max:60',
            'color' => ['required', Rule::in(config('studio.colors'))], 'timeframe' => 'nullable|string|max:100', 'budget' => 'nullable|integer|min:0|max:1000000',
            'artist_id' => 'nullable|exists:artists,id', 'consultation' => 'boolean',
            'reference' => 'nullable|image|max:5120',
        ];
    }

    /** Fields persisted on the quote (the upload is handled separately). */
    public function quoteData(): array { return collect($this->validated())->except('reference')->all() + ['consultation' => $this->boolean('consultation')]; }
}
