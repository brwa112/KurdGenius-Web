<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampusRequest extends FormRequest
{
    public function rules(): array
    {
        $campusId = $this->route('campus') ? $this->route('campus')->id : null;

        return [
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.ckb' => 'nullable|string|max:255',
            'name.ar' => 'nullable|string|max:255',
            
            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.ckb' => 'nullable|string',
            'description.ar' => 'nullable|string',
            
            'full_description' => 'nullable|array',
            'full_description.en' => 'nullable|string',
            'full_description.ckb' => 'nullable|string',
            'full_description.ar' => 'nullable|string',
            
            'location' => 'nullable|array',
            'location.en' => 'nullable|string|max:255',
            'location.ckb' => 'nullable|string|max:255',
            'location.ar' => 'nullable|string|max:255',
            
            'address' => 'nullable|array',
            'address.en' => 'nullable|string',
            'address.ckb' => 'nullable|string',
            'address.ar' => 'nullable|string',
            
            'slug' => 'nullable|string|max:255|unique:campuses,slug,' . $campusId,
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'map_url' => 'nullable|url|max:500',
            'facilities' => 'nullable|array',
            'metadata' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            
            'featured_image' => $campusId ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120' : 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_featured_image' => 'nullable|boolean',
            
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_gallery' => 'nullable|boolean',

            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.en.required' => 'The English name is required.',
        ];
    }
}
