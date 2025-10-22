<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{
    public function rules(): array
    {
        $classroomId = $this->route('classroom') ? $this->route('classroom')->id : null;

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
            
            'slug' => 'nullable|string|max:255|unique:classrooms,slug,' . $classroomId,
            'classroom_type' => 'nullable|string|max:100',
            'building' => 'nullable|string|max:100',
            'floor' => 'nullable|string|max:50',
            'room_number' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:0',
            'equipment' => 'nullable|array',
            'features' => 'nullable|array',
            'schedule' => 'nullable|array',
            'metadata' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            
            'featured_image' => $classroomId ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120' : 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_featured_image' => 'nullable|boolean',
            
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_gallery' => 'nullable|boolean',
            
            'floor_plan' => $classroomId ? 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240' : 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240',
            'remove_floor_plan' => 'nullable|boolean',

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
