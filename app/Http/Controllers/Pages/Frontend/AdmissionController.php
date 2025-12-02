<?php

namespace App\Http\Controllers\Pages\Frontend;

use App\Models\Pages\Admission\AdmissionPolicy;
use App\Models\Pages\Admission\AdmissionDocument;
use App\Http\Controllers\Controller;

class AdmissionController extends Controller
{
    public function index()
    {
        // Get the selected branch ID from session
        $branchId = session('selected_branch_id');

        // Fetch admission policy data for the selected branch (only if active)
        $policy = AdmissionPolicy::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->first();

        // Fetch admission documents data for the selected branch (only if active)
        $document = AdmissionDocument::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->first();

        // Transform data for frontend
        $policyData = $policy ? [
            'description' => $policy->getTranslations('description'),
            'requirements' => $policy->getTranslations('requirements'),
            'steps' => $policy->getTranslations('steps'),
        ] : null;

        $documentData = $document ? [
            'documents' => $document->getTranslations('documents'),
        ] : null;

        return inertia('Frontend/Pages/Admission/Index', [
            'policy' => $policyData,
            'document' => $documentData,
        ]);
    }
}
