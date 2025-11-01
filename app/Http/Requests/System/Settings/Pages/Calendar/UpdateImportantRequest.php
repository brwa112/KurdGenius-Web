<?php

namespace App\Http\Requests\System\Settings\Pages\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImportantRequest extends FormRequest
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
            'events' => 'required|array',
            'events.en' => 'required|array|min:1',
            'events.en.*' => 'required|array',
            'events.en.*.name' => 'required|string',
            'events.en.*.date' => 'required|string',
            'events.ckb' => 'required|array|min:1',
            'events.ckb.*' => 'required|array',
            'events.ckb.*.name' => 'required|string',
            'events.ckb.*.date' => 'required|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'events.en' => __('system.important_dates') . ' (' . __('system.en') . ')',
            'events.en.*.name' => __('system.event_name') . ' (' . __('system.en') . ')',
            'events.en.*.date' => __('system.date') . ' (' . __('system.en') . ')',
            'events.ckb' => __('system.important_dates') . ' (' . __('system.ckb') . ')',
            'events.ckb.*.name' => __('system.event_name') . ' (' . __('system.ckb') . ')',
            'events.ckb.*.date' => __('system.date') . ' (' . __('system.ckb') . ')',
        ];
    }
}
