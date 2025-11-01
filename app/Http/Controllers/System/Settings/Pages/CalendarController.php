<?php

namespace App\Http\Controllers\System\Settings\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Settings\Pages\Calendar\UpdateAcademicRequest;
use App\Http\Requests\System\Settings\Pages\Calendar\UpdateOfficialRequest;
use App\Http\Requests\System\Settings\Pages\Calendar\UpdateImportantRequest;
use App\Models\Pages\Branch;
use App\Models\Pages\Calendar\CalendarAcademic;
use App\Models\Pages\Calendar\CalendarOfficial;
use App\Models\Pages\Calendar\CalendarImportant;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $branchId = $request->input('branch_id') ?? Branch::active()->ordered()->first()->id;

        $academic = CalendarAcademic::where('branch_id', $branchId)->first();
        $official = CalendarOfficial::where('branch_id', $branchId)->first();
        $important = CalendarImportant::where('branch_id', $branchId)->first();

        return inertia('System/Settings/Pages/Calendar/Index', [
            'academic' => $academic ? [
                'id' => $academic->id,
                'description' => $academic->getTranslations('description'),
                'activities' => $academic->getTranslations('activities'),
                'is_active' => $academic->is_active,
            ] : null,
            'official' => $official ? [
                'id' => $official->id,
                'description' => $official->getTranslations('description'),
                'holidays' => $official->getTranslations('holidays'),
                'is_active' => $official->is_active,
            ] : null,
            'important' => $important ? [
                'id' => $important->id,
                'events' => $important->getTranslations('events'),
                'is_active' => $important->is_active,
            ] : null,
        ]);
    }

    public function updateAcademic(UpdateAcademicRequest $request)
    {
        $validated = $request->validated();

        $academic = CalendarAcademic::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? ['en' => '', 'ckb' => ''],
            'activities' => $validated['activities'] ?? ['en' => [], 'ckb' => []],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $academic->update([
            'user_id' => auth()->id(),
            'description' => $validated['description'] ?? $academic->description,
            'activities' => $validated['activities'] ?? $academic->activities,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->back()->with('success', trans('common.record') . ' ' . trans('common.updated'));
    }

    public function updateOfficial(UpdateOfficialRequest $request)
    {
        $validated = $request->validated();

        $official = CalendarOfficial::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? ['en' => '', 'ckb' => ''],
            'holidays' => $validated['holidays'] ?? ['en' => [], 'ckb' => []],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $official->update([
            'user_id' => auth()->id(),
            'description' => $validated['description'] ?? $official->description,
            'holidays' => $validated['holidays'] ?? $official->holidays,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->back()->with('success', trans('common.record') . ' ' . trans('common.updated'));
    }

    public function updateImportant(UpdateImportantRequest $request)
    {
        $validated = $request->validated();

        $important = CalendarImportant::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'events' => $validated['events'] ?? ['en' => [], 'ckb' => []],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $important->update([
            'user_id' => auth()->id(),
            'events' => $validated['events'] ?? $important->events,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->back()->with('success', trans('common.record') . ' ' . trans('common.updated'));
    }
}
