<?php

namespace App\Http\Requests\System\Settings\Pages\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'videos.*' => 'nullable|mimes:mp4,webm|max:51200',
            'remove_gallery' => 'nullable|boolean',
            'remove_videos' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'gallery.*' => __('system.image'),
            'videos.*' => __('system.video'),
        ];
    }
}
