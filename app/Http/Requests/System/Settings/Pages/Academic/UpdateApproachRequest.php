<?php

namespace App\Http\Requests\System\Settings\Pages\Academic;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApproachRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'branch_id' => 'required|exists:branches,id',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'description.ckb' => 'required|string',
            'description.ar' => 'nullable|string',
            'features' => 'required|array',
            'features.en' => 'required|array|min:1|max:10',
            'features.en.*.title' => 'required|string',
            'features.ckb' => 'required|array|min:1|max:10',
            'features.ckb.*.title' => 'required|string',
            'features.ar' => 'nullable|array|max:10',
            'features.ar.*.title' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'description.en' => __('system.description') . ' (' . __('system.en') . ')',
            'description.ckb' => __('system.description') . ' (' . __('system.ckb') . ')',
            'description.ar' => __('system.description') . ' (' . __('system.ar') . ')',
            'features.en' => __('system.features') . ' (' . __('system.en') . ')',
            'features.en.*.title' => __('system.feature') . ' (' . __('system.en') . ')',
            'features.ckb' => __('system.features') . ' (' . __('system.ckb') . ')',
            'features.ckb.*.title' => __('system.feature') . ' (' . __('system.ckb') . ')',
            'features.ar' => __('system.features') . ' (' . __('system.ar') . ')',
            'features.ar.*.title' => __('system.feature') . ' (' . __('system.ar') . ')',
        ];
    }
}
