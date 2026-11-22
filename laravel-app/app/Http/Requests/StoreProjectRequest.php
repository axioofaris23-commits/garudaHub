<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'category'     => ['required', 'string', 'max:100'],
            'budget'       => ['required', 'integer', 'min:1'],
            'bid_deadline' => ['required', 'date', 'after:now'],
        ];
    }
}