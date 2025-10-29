<?php

namespace App\Http\Requests\System\Settings\Pages\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMissionRequest extends FormRequest
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
            'goals' => 'nullable|array',
            //'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            //'remove_images' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [];
    }
}
