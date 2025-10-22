<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        $newsId = $this->route('news') ? $this->route('news')->id : null;

        return [
            'title' => 'required|array',
            'title.en' => 'required_without_all:title.ckb|nullable|string|max:255',
            'title.ckb' => 'required_without_all:title.en|nullable|string|max:255',

            'content' => 'required|array',
            'content.en' => 'required_without_all:content.ckb|nullable|string',
            'content.ckb' => 'required_without_all:content.en|nullable|string',

            'category_id' => 'required|exists:categories,id',
            'hashtag_ids' => 'nullable|array',
            'hashtag_ids.*' => 'exists:hashtags,id',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',

            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_images' => 'nullable|boolean',

            'user_id' => 'required|exists:users,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'title.en' => __('pages.title.en'),
            'content.en' => __('pages.content.en'),
            'title.ckb' => __('pages.title.ckb'),
            'content.ckb' => __('pages.content.ckb')
        ];
    }
}
