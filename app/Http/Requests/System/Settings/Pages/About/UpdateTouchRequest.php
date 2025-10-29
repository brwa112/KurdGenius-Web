<?php

namespace App\Http\Requests\System\Settings\Pages\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTouchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|array',
            'subtitle' => 'nullable|array',
            'description' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'contact_address' => 'nullable|array',
            //'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            //'remove_images' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [];
    }
}
