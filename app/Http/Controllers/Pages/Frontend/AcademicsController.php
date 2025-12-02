<?php

namespace App\Http\Controllers\Pages\Frontend;

use App\Models\Pages\Academic\AcademicApproach;
use App\Models\Pages\Academic\AcademicChoose;
use App\Http\Controllers\Controller;

class AcademicsController extends Controller
{
    public function index()
    {
        // Get the selected branch ID from session
        $branchId = session('selected_branch_id');

        // Fetch academic approach data for the selected branch
        $approach = AcademicApproach::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->ordered()
            ->first();

        // Fetch academic choose data for the selected branch
        $choose = AcademicChoose::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->ordered()
            ->first();

        // Transform data for frontend
        $approachData = $approach ? [
            'description' => $approach->getTranslations('description'),
            'features' => $approach->getTranslations('features'),
        ] : null;

        $chooseData = $choose ? [
            'description' => $choose->getTranslations('description'),
            'reasons' => $choose->getTranslations('reasons'),
        ] : null;

        return inertia('Frontend/Pages/Academic/Index', [
            'approach' => $approachData,
            'choose' => $chooseData,
        ]);
    }
}

