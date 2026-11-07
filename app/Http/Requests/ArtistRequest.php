<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistRequest extends FormRequest
{
    public function rules(): array
    {
        return ['name' => 'required|max:100', 'specialty' => 'required|max:100', 'city' => 'required|max:100', 'bio' => 'required|max:1000'];
    }
}
