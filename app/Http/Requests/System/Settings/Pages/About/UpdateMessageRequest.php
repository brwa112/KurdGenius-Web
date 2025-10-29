<?php

namespace App\Http\Requests\System\Settings\Pages\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
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
            'author' => 'nullable|array',
            'author_position' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'remove_author_image' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'image' => __('system.principal_image'),
        ];
    }
}
