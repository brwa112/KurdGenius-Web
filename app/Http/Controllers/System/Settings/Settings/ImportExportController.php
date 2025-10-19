<?php

namespace App\Http\Controllers\System\Settings\Settings;

use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Exports\TranslationsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    use LogsActivity;
    
    public function export(Request $request)
    {
        $language = $request->language;
        
        return Excel::download(new TranslationsExport($language), 'translations.xlsx');
    }
}
