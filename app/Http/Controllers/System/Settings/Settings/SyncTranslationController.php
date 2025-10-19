<?php

namespace App\Http\Controllers\System\Settings\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class SyncTranslationController extends Controller
{
    public function syncTranslations(Request $request)
    {
        Artisan::call('translations:cache');
    }
}
