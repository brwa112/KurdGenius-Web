<?php

namespace App\Http\Requests\System\Settings\Pages\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicRequest extends FormRequest
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
            'activities' => 'required|array',
            'activities.en' => 'required|array|min:1',
            'activities.en.*' => 'required|string',
            'activities.ckb' => 'required|array|min:1',
            'activities.ckb.*' => 'required|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'description.en' => __('system.description') . ' (' . __('system.en') . ')',
            'description.ckb' => __('system.description') . ' (' . __('system.ckb') . ')',
            'activities.en' => __('system.activities') . ' (' . __('system.en') . ')',
            'activities.en.*' => __('system.activity') . ' (' . __('system.en') . ')',
            'activities.ckb' => __('system.activities') . ' (' . __('system.ckb') . ')',
            'activities.ckb.*' => __('system.activity') . ' (' . __('system.ckb') . ')',
        ];
    }
}
