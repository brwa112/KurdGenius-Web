<?php

namespace App\Http\Requests\System\Settings\Pages\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Remove image field if it's not a file upload (e.g., existing image URL string)
        if ($this->has('image') && is_string($this->input('image')) && !$this->hasFile('image')) {
            $this->getInputSource()->remove('image');
        }
    }

    public function rules(): array
    {
        return [
            'description' => 'nullable|array',
            'author' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'remove_author_image' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'branch_id' => 'nullable|integer',
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
