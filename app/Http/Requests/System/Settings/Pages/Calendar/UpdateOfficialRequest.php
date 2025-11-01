<?php

namespace App\Http\Requests\System\Settings\Pages\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficialRequest extends FormRequest
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
            'holidays' => 'required|array',
            'holidays.en' => 'required|array|min:1',
            'holidays.en.*' => 'required|string',
            'holidays.ckb' => 'required|array|min:1',
            'holidays.ckb.*' => 'required|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'description.en' => __('system.description') . ' (' . __('system.en') . ')',
            'description.ckb' => __('system.description') . ' (' . __('system.ckb') . ')',
            'holidays.en' => __('system.holidays') . ' (' . __('system.en') . ')',
            'holidays.en.*' => __('system.holiday') . ' (' . __('system.en') . ')',
            'holidays.ckb' => __('system.holidays') . ' (' . __('system.ckb') . ')',
            'holidays.ckb.*' => __('system.holiday') . ' (' . __('system.ckb') . ')',
        ];
    }
}
