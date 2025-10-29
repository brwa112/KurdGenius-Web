<?php

namespace App\Http\Requests\System\Settings\Pages\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'title.ckb' => 'nullable|string|max:255',
            'subtitle' => 'nullable|array',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'description.ckb' => 'nullable|string',
            'established_year' => 'nullable|integer',
            'founder' => 'nullable|array',
            'achievements' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'remove_images' => 'nullable|boolean',
            'remove_image' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'title.en' => __('system.title') . ' (' . __('system.en') . ')',
            'description.en' => __('system.description') . ' (' . __('system.en') . ')',
            'images.*' => __('system.image'),
            'image' => __('system.image'),
        ];
    }
}
